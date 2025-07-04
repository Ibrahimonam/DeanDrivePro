<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassModel;
use App\Notifications\SmsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SMSController extends Controller
{
    protected function sendTo($students, string $message)
    {
        Notification::send($students, new SmsNotification($message));
    }

    public function sms_all_students()
    {
        return view('sms.sms_all_students');
    }

    public function send_all_students_sms(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        $students = Student::where('student_status','active')
            ->where('branch_id', Auth::user()->branch_id)
            ->get();

        $this->sendTo($students, $request->message);

        return back()->with('message', 'Messages queued for all active students.');
    }

    public function sms_all_class_students()
    {
        $courses = ClassModel::all();
        return view('sms.sms_all_class_students', compact('courses'));
    }

    public function send_all_class_students_sms(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'message'  => 'required|string',
        ]);
        $students = Student::where('student_status', 'active')
            ->where('branch_id', Auth::user()->branch_id)
            ->where('class_id', $request->class_id)
            ->get();

        $this->sendTo($students, $request->message);

        return back()->with('message', 'Messages queued for selected class.');
    }

    public function sms_all_students_and_alumnae()
    {
        return view('sms.sms_all_students_and_alumnae');
    }

    public function send_all_students_and_alumnae_sms(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        $students = Student::all(); // or add status filter if needed

        $this->sendTo($students, $request->message);

        return back()->with('message', 'Messages queued for all students & alumnae.');
    }
}
