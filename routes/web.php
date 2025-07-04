<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\PracticalController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FeeInvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboards.user_dash_board');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/zones', ZoneController::class )->name('*','zones'); 

    Route::get('/zone/download', [ZoneController::class, 'exportPDF'])->name('zones.download');

     // Branch dashboard
     Route::get('branches/dashboard', [BranchController::class, 'dashboard'])
     ->name('branches.dashboard');

    Route::resource('/branches', BranchController::class )->name('*','branches');

    Route::get('/branch/download', [BranchController::class, 'exportPDF'])->name('branches.download');

    Route::resource('/classes', ClassController::class )->name('*','classes');

    Route::resource('/practicals', PracticalController::class )->name('*','practicals');

    Route::resource('/teachers', TeacherController::class )->name('*','teachers');

    // Show students for a specific branch
    Route::get('branches/{branch}/students', [StudentController::class, 'byBranch'])
         ->name('branches.students.index');

    Route::post('/students/{student}/issue-practical', [StudentController::class, 'issuePractical'])->name('students.issue-practical');


    Route::get('students/alumni', [StudentController::class, 'alumni'])
        ->name('students.alumni');
    // Show a single alumni student
    Route::get('students/alumni/{student}', [StudentController::class, 'showAlumni'])
    ->name('students.alumni.show');

    // List all “expired” students
    Route::get('students/expired', [StudentController::class, 'expired'])
            ->name('students.expired.index');

    // Show details for one expired student
    Route::get('students/expired/{student}', [StudentController::class, 'showExpired'])
            ->name('students.expired.show');

    Route::resource('/students', StudentController::class )->name('*','students');





    // Fee Invoices CRUD

    // Payments Dashboard
    Route::get('invoices/dashboard', [FeeInvoiceController::class, 'dashboard'])
    ->name('invoices.dashboard');

      // Invoices scoped to a branch
      Route::get('branches/{branch}/invoices', [FeeInvoiceController::class, 'byBranch'])
      ->name('branches.invoices.index');

    Route::resource('invoices', FeeInvoiceController::class);

    Route::get('/payments/{payment}/download', [PaymentController::class, 'download'])->name('payments.download');


    // Nested Payments under Invoices
    Route::prefix('invoices/{invoice}')->name('invoices.')->group(function() {
        // Record a new payment
        Route::post('payments', [PaymentController::class, 'store'])
            ->name('payments.store');

        // Show edit form for a payment
        Route::get('payments/{payment}/edit', [PaymentController::class, 'edit'])
            ->name('payments.edit');

        // Update a payment
        Route::put('payments/{payment}', [PaymentController::class, 'update'])
            ->name('payments.update');

        // Delete a payment
        Route::delete('payments/{payment}', [PaymentController::class, 'destroy'])
            ->name('payments.destroy');
    });

    Route::resource('/expenses', ExpenseController::class )->name('*','expenses');



    /* REPORTS ROUTES*/

    //Student enrolment reports by branch or all branches

    // Show the date‐range form & report
    Route::get('students/reports/enrollment', [StudentController::class, 'enrollmentReport'])
         ->name('students.reports.enrollment');

    // Download the report as PDF
    Route::get('students/reports/enrollment/download', [StudentController::class, 'enrollmentReportDownload'])
         ->name('students.reports.enrollment.download');


         //Payments

             // Payments report form & listing
    Route::get('reports/payments', [PaymentController::class, 'paymentsReport'])
    ->name('reports.payments');

    // Download payments report as PDF
    Route::get('reports/payments/download', [PaymentController::class, 'paymentsReportDownload'])
        ->name('reports.payments.download');

      

         // Zone payments report
    Route::get('reports/payments/zone', [PaymentController::class, 'paymentsZoneReport'])
    ->name('reports.payments.zone');

    Route::get('reports/payments/zone/download', [PaymentController::class, 'paymentsZoneReportDownload'])
    ->name('reports.payments.zone.download');

    // Zonal Enrollment

     // Show & filter form
     Route::get('reports/enrollment/zone', [StudentController::class, 'enrollmentZoneReport'])
     ->name('reports.enrollment.zone');

    // Download PDF
    Route::get('reports/enrollment/zone/download', [StudentController::class, 'enrollmentZoneReportDownload'])
        ->name('reports.enrollment.zone.download');


        // Expenses Reports

    Route::get('reports/expenses', [ExpenseController::class, 'expensesReport'])->name('reports.expenses');

    Route::get('reports/expenses/download', [ExpenseController::class, 'expensesReportDownload'])->name('reports.expenses.download');



    //SMS

    Route::prefix('sms')->controller(SMSController::class)->name('sms.')->group(function () {
    Route::get('/all-students', 'sms_all_students')->name('all_students');
    Route::post('/all-students', 'send_all_students_sms')->name('send_all_students');

    Route::get('/class-students', 'sms_all_class_students')->name('class_students');
    Route::post('/class-students', 'send_all_class_students_sms')->name('send_all_class_students');

    Route::get('/all-students-and-alumnae', 'sms_all_students_and_alumnae')->name('all_students_and_alumnae');
    Route::post('/all-students-and-alumnae', 'send_all_students_and_alumnae_sms')->name('send_all_students_and_alumnae');
});



});


// Admin User Management
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});

/*  My new Routes */

Route::get('/admin', function () {
    return 'Admin Page';
})->middleware('role:admin');

Route::get('/editor', function () {
    return 'Editor Page';
})->middleware('role:editor,admin');



require __DIR__.'/auth.php';
