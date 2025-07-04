<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Branch;
use App\Models\Practical;
use App\Models\Zone;
use App\Models\ClassModel;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\WelcomeStudentMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;


use App\Notifications\SmsNotification;

class StudentController extends Controller
{
    /**
     * Display a listing of the students, with search & pagination.
     */
     
     public function index(Request $request)
     {
         $search = $request->query('search');
         $user   = Auth::user();
         $branch = $user->branch_id;
         $zone   = $user->zone_id;
        // $role   = $user->role->name; // or use $user->role_id if you prefer
        $role = $user->getRoleNames()->join(', ');

         // Base query: only active students, with eager‐loads
         $query = Student::with(['branch', 'class'])
                         ->where('student_status', 'active');
     
         // Apply branch/zone filtering by role
         if ($role === 'User') {
             // Only see students in your branch
             $query->where('branch_id', $branch);
         } elseif ($role === 'Management') {
             // Only see students whose branch.zone_id matches your zone
             $query->whereHas('branch', function($q) use ($zone) {
                 $q->where('zone_id', $zone);
             });
         }
         // Admin sees all active students
     
         // Apply search if present
         if ($search) {
             $query->where(function($q) use ($search) {
                 $q->where('id_number', 'like', "%{$search}%")
                   ->orWhere('first_name', 'like', "%{$search}%")
                   ->orWhere('middle_name', 'like', "%{$search}%")
                   ->orWhere('last_name', 'like', "%{$search}%");
             });
         }
     
         // Fetch & paginate
         $students = $query
             ->orderBy('last_name')
             ->paginate(10)
             ->withQueryString();
     
         return view('students.index', compact('students', 'search'));
     }
     


    /**
     * Show form for creating a new student.
     */
    public function create()
    {
        $branches = Branch::orderBy('name')->get();
        $classes  = ClassModel::orderBy('name')->get();
        return view('students.create', compact('branches', 'classes'));
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:50',
            'middle_name'    => 'nullable|string|max:50',
            'last_name'      => 'required|string|max:50',
            'email'          => 'required|email|unique:students,email',
            'phone_number'   => 'required|string|max:20',
            'id_number'      => 'required|string|max:20|unique:students,id_number',
            'branch_id'      => 'required|exists:branches,id',
            'class_id'       => 'required|exists:classes,id',
            'pdl_status'     => 'in:Booked,Not Booked,Accepted',
            'exam_status'    => 'in:Booked,Not Booked',
            'tshirt_status'  => 'in:Issued,Not Issued',
            'student_status' => 'in:Active,Cleared,Expired',
        ]);

        // 1️⃣ Create student in a transaction
        $student = DB::transaction(fn() => Student::create($data));

        // 2️⃣ Queue the welcome email
        Mail::to($student->email)
            ->send(new WelcomeStudentMail($student));

        // 3️⃣ Send a welcome SMS (queues via your SmsLeopardChannel)
        $className = $student->class->name;
        $message   = "Hello {$student->first_name}, welcome to your {$className} class at Dean Driving School! We look forward to seeing you on your first lesson.";
        $student->notify(new SmsNotification($message, 'welcome'));

        return redirect()
            ->route('students.index')
            ->with('success', 'Student created successfully. A welcome email and SMS are on their way!');
    }
    

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load('branch', 'class', 'invoices','practicals');
        return view('students.show', compact('student'));
    }

    /**
     * Show form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $branches = Branch::orderBy('name')->get();
        $classes  = ClassModel::orderBy('name')->get();
        return view('students.edit', compact('student', 'branches', 'classes'));
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:50',
            'middle_name'    => 'nullable|string|max:50',
            'last_name'      => 'required|string|max:50',
            'email'          => 'required|email|unique:students,email,' . $student->id,
            'phone_number'   => 'required|string|max:20',
            'id_number'      => 'required|string|max:20|unique:students,id_number,' . $student->id,
            'branch_id'      => 'required|exists:branches,id',
            'class_id'       => 'required|exists:classes,id',
            'pdl_status'     => 'required|in:Booked,Not Booked,Accepted',
            'exam_status'    => 'required|in:Booked,Not Booked',
            'tshirt_status'  => 'required|in:Issued,Not Issued',
            'student_status' => 'required|in:Active,Cleared,Expired',
        ]);

        $student->update($data);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Soft-delete the specified student, capturing who deleted it.
     */
  
     public function destroy(Student $student)
{
    $user = Auth::user();

    // Only Admins may delete students
    if (!$user->hasRole('Admin')) {
        abort(403, 'Unauthorized');
    }

    DB::transaction(function () use ($student) {
        // 1) Track who deleted
        $student->deleted_by = Auth::id();
        $student->save();

        // 2) Soft-delete all payments of all invoices
        foreach ($student->invoices as $invoice) {
            $invoice->payments()->delete();
        }

        // 3) Soft-delete all invoices
        $student->invoices()->delete();

        // 4) Remove practical assignments (pivot table)
        $student->practicals()->detach();

        // 5) Finally soft-delete the student
        $student->delete();
    });

    return redirect()
        ->route('students.index')
        ->with('success', 'Student and all related data deleted successfully.');
}



    /**
     * Display a listing of the Alumni students, with search & pagination.
     */

    public function alumni(Request $request)
    {
        //dd('here');
        $search = $request->query('search');
        $user   = Auth::user();
        $branch = $user->branch_id;
        $zone   = $user->zone_id;
        $role   = $user->role->name; // or use $user->role_id

        // Base query: only Cleared students
        $query = Student::with(['branch', 'class'])
                        ->where('student_status', 'Cleared');

        // Role-based branch/zone filtering
        if ($role === 'User') {
            $query->where('branch_id', $branch);
        } elseif ($role === 'Management') {
            $query->whereHas('branch', function($q) use ($zone) {
                $q->where('zone_id', $zone);
            });
        }
        // Admin sees all Cleared

        // Optional search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id_number', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('middle_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        // Paginate & return
        $students = $query
            ->orderBy('last_name')
            ->paginate(10)
            ->withQueryString();

        return view('students.alumni', compact('students', 'search'));
    }

        /**
     * Display the details for a single expiredCleared (alumni) student,
     * including all their invoices and payments.
     */
    public function showAlumni(Student $student)
    {
        $user   = Auth::user();
        $branch = $user->branch_id;
        $zone   = $user->zone_id;
        $role   = $user->role->name;

        // 1) Only allow expired students
        if ($student->student_status !== 'Cleared') {
            abort(404);
        }

        // 2) Enforce the same branch/zone scoping you use in index
        if ($role === 'User' && $student->branch_id !== $branch) {
            abort(403);
        }
        if ($role === 'Management' && $student->branch->zone_id !== $zone) {
            abort(403);
        }
        // Admin bypasses

        // 3) Load invoices + payments eagerly
        $student->load([
            'branch',
            'class',
            'invoices.payments'  // assumes FeeInvoice has payments()
        ]);

        return view('students.show_alumni', [
            'student'  => $student,
        ]);
    }

    /**
     * Display a listing of the Expired students, with search & pagination.
     */

     public function expired(Request $request)
     {
         //dd('here');
         $search = $request->query('search');
         $user   = Auth::user();
         $branch = $user->branch_id;
         $zone   = $user->zone_id;
         $role   = $user->role->name; // or use $user->role_id
 
         // Base query: only Expired students
         $query = Student::with(['branch', 'class'])
                         ->where('student_status', 'Expired');
 
         // Role-based branch/zone filtering
         if ($role === 'User') {
             $query->where('branch_id', $branch);
         } elseif ($role === 'Management') {
             $query->whereHas('branch', function($q) use ($zone) {
                 $q->where('zone_id', $zone);
             });
         }
         // Admin sees all Cleared
 
         // Optional search
         if ($search) {
             $query->where(function($q) use ($search) {
                 $q->where('id_number', 'like', "%{$search}%")
                 ->orWhere('first_name', 'like', "%{$search}%")
                 ->orWhere('middle_name', 'like', "%{$search}%")
                 ->orWhere('last_name', 'like', "%{$search}%");
             });
         }
 
         // Paginate & return
         $students = $query
             ->orderBy('last_name')
             ->paginate(10)
             ->withQueryString();
 
         return view('students.expired', compact('students', 'search'));
     }

             /**
     * Display the details for a single expired (Expired) student,
     * including all their invoices and payments.
     */
    public function showExpired(Student $student)
    {
        $user   = Auth::user();
        $branch = $user->branch_id;
        $zone   = $user->zone_id;
        $role   = $user->role->name;

        // 1) Only allow expired students
        if ($student->student_status !== 'Expired') {
            abort(404);
        }

        // 2) Enforce the same branch/zone scoping you use in index
        if ($role === 'User' && $student->branch_id !== $branch) {
            abort(403);
        }
        if ($role === 'Management' && $student->branch->zone_id !== $zone) {
            abort(403);
        }
        // Admin bypasses

        // 3) Load invoices + payments eagerly
        $student->load([
            'branch',
            'class',
            'invoices.payments'  // assumes FeeInvoice has payments()
        ]);

        return view('students.show_expired', [
            'student'  => $student,
        ]);
    }

    // Issue Practical Lessons to a student

    public function issuePractical(Request $request, Student $student)
    {
        $request->validate([
            'practical_id' => 'required|exists:practicals,id',
        ]);

        // Avoid re-issuing the same lesson
        if ($student->practicals()->where('practical_id', $request->practical_id)->exists()) {
            return back()->with('error', 'Practical lesson already issued to this student.');
        }

        // Attach the practical to the student with timestamp
        $student->practicals()->attach($request->practical_id, ['issued_at' => now()]);

        // Get the practical lesson
        $practical = Practical::find($request->practical_id);

        // Create the SMS message
        $message = "Hello {$student->first_name}, you have been scheduled for the '{$practical->name}' lesson today. Please be on time and prepared.";

        // Send SMS using notification
        $student->notify(new SmsNotification($message, 'practical'));

        return back()->with('success', 'Practical lesson issued and SMS sent to student.');
    }

    // Get students by branch

    public function byBranch(Request $request, Branch $branch)
    {
        $user = Auth::user();

        // Authorization using Spatie roles
        if ($user->hasRole('User') && $branch->id !== $user->branch_id) {
            abort(403, 'Unauthorized');
        }

        if ($user->hasRole('Management') && $branch->zone_id !== $user->zone_id) {
            abort(403, 'Unauthorized');
        }

        // Base query: Active students from this branch
        $query = Student::with(['branch', 'class'])
            ->where('branch_id', $branch->id)
            ->where('student_status', 'active');

        // Optional search
        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('id_number', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $students = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('students.index', [
            'students'  => $students,
            'search'    => $search,
            'backUrl'   => route('branches.dashboard'),
            'backText'  => '← Back to Branches',
            'pageTitle' => "Students in “{$branch->name}”",
        ]);
    }

    // REPORTS

    //Enrolment reports

      /**
     * Show the enrollment report form and table.
     */
    public function enrollmentReport(Request $request)
{
    // 1️⃣ Validate inputs
    $request->validate([
        'branch_id'  => ['nullable','integer','exists:branches,id'],
        'start_date' => ['nullable','date'],
        'end_date'   => ['nullable','date','after_or_equal:start_date'],
    ]);

    // 2️⃣ Build branch list for dropdown (scoped by role)
    $user = Auth::user();
    $branchesQuery = Branch::orderBy('name');

    if ($user->hasRole('Management')) {
        $branchesQuery->where('zone_id', $user->zone_id);
    } elseif ($user->hasRole('User')) {
        $branchesQuery->where('id', $user->branch_id);
    }
    
    $branches = $branchesQuery->get();

    // 3️⃣ Only run the report if dates provided
    $students = collect();
    if ($request->filled(['start_date', 'end_date'])) {
        $studentsQuery = Student::with(['branch','class'])
            ->whereBetween('created_at', [
                $request->start_date.' 00:00:00',
                $request->end_date.' 23:59:59',
            ]);

        // 4️⃣ Optional branch filter
        if ($request->filled('branch_id')) {
            $studentsQuery->where('branch_id', $request->branch_id);
        }

        $students = $studentsQuery
            ->orderBy('created_at')
            ->get();
    }

    return view('students.enrollment_report', [
        'branches'       => $branches,
        'students'       => $students,
        'start_date'     => $request->start_date,
        'end_date'       => $request->end_date,
        'selectedBranch' => $request->branch_id,
    ]);
}

    /**
     * Download the enrollment report as PDF.
     */
    public function enrollmentReportDownload(Request $request)
    {
        $request->validate([
            'branch_id'  => ['nullable','integer','exists:branches,id'],
            'start_date' => ['required','date'],
            'end_date'   => ['required','date','after_or_equal:start_date'],
        ]);

        // Build the same query
        $studentsQuery = Student::with(['branch','class'])
            ->whereBetween('created_at', [
                $request->start_date.' 00:00:00',
                $request->end_date.' 23:59:59',
            ]);

        if ($request->filled('branch_id')) {
            $studentsQuery->where('branch_id', $request->branch_id);
            $branchName = Branch::find($request->branch_id)->name;
        } else {
            $branchName = 'All Branches';
        }

        $students = $studentsQuery->orderBy('created_at')->get();

        $pdf = Pdf::loadView('students.pdfs.enrollment_report', [
            'students'    => $students,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'branchName'  => $branchName,
        ])->setPaper('a4','landscape');

        $filename = "enrollment_{$request->start_date}_{$request->end_date}.pdf";
        return $pdf->download($filename);
    }

     /**
     * Show enrollment report scoped by zone.
     */
    public function enrollmentZoneReport(Request $request)
    {
        $request->validate([
            'zone_id'    => ['nullable','integer','exists:zones,id'],
            'start_date' => ['nullable','date'],
            'end_date'   => ['nullable','date','after_or_equal:start_date'],
        ]);

        $user = Auth::user();
       // $role = $user->role->name;
        $ownZone = $user->zone_id;

        // Build zone dropdown
        if ($user->hasRole('Admin')) {
            $zones = Zone::orderBy('name')->get();
            $selectedZone = $request->zone_id;
        }
        elseif ($user->hasRole('Management')) {
            $zones = Zone::where('id', $ownZone)->get();
            $selectedZone = $ownZone;
        }
        else {
            abort(403, 'Unauthorized');
        }

        $students = collect();
        if ($request->filled(['start_date','end_date'])) {
            $q = Student::with(['branch','class'])
                ->whereBetween('created_at', [
                    "{$request->start_date} 00:00:00",
                    "{$request->end_date} 23:59:59",
                ]);

            if ($selectedZone) {
                $q->whereHas('branch', function($b) use($selectedZone) {
                    $b->where('zone_id', $selectedZone);
                });
            }

            $students = $q->orderBy('created_at')->get();
        }

        return view('students.enrollment_zone_report', [
            'zones'         => $zones,
            'students'      => $students,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'selectedZone'  => $selectedZone,
        ]);
    }

    /**
     * Download the zone enrollment report as PDF.
     */
    public function enrollmentZoneReportDownload(Request $request)
    {
        $request->validate([
            'zone_id'    => ['nullable','integer','exists:zones,id'],
            'start_date' => ['required','date'],
            'end_date'   => ['required','date','after_or_equal:start_date'],
        ]);

        $user = Auth::user();
        //$role = $user->role->name;
        $ownZone = $user->zone_id;

        // Determine zone filter
        if ($user->hasRole('Admin')) {
            $selectedZone = $request->zone_id;
        }
        elseif ($user->hasRole('Management')) {
            $selectedZone = $ownZone;
        }
        else {
            abort(403, 'Unauthorized');
        }

        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        $q = Student::with(['branch','class'])
            ->whereBetween('created_at', [
                "{$start_date} 00:00:00",
                "{$end_date} 23:59:59",
            ]);

        if ($selectedZone) {
            $q->whereHas('branch', fn($b)=> $b->where('zone_id',$selectedZone));
            $zoneName = Zone::find($selectedZone)->name;
        } else {
            $zoneName = 'All Zones';
        }

        $students = $q->orderBy('created_at')->get();

        $pdf = Pdf::loadView('students.pdfs.enrollment_zone_report', [
            'students'   => $students,
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'zoneName'   => $zoneName,
        ])->setPaper('a4','landscape');

        $filename = "enrollment_zone_{$start_date}_{$end_date}.pdf";
        return $pdf->download($filename);
    }

 
}
