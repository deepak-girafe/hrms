<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LeavePolicyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\DailyEodController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
Route::redirect('/', '/login');

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    Route::resource('employees', EmployeeController::class);
    Route::resource('roles', RoleController::class);
    Route::post('roles/status/{role}', [RoleController::class, 'status'])
    ->name('roles.status');
    Route::resource('users', UserController::class);
    Route::resource('departments', DepartmentController::class);
    Route::post(
        'departments/status/{department}',
        [DepartmentController::class, 'status']
    )->name('departments.status');
    Route::resource('holidays', HolidayController::class);

    Route::post(
        'holidays/status/{holiday}',
        [HolidayController::class, 'status']
    )->name('holidays.status');

    Route::resource('leave-types', LeaveTypeController::class);

    Route::resource('leave-policies', LeavePolicyController::class);

    Route::post(
        'leave-types/status/{leaveType}',
        [LeaveTypeController::class, 'status']
    )->name('leave-types.status');

    Route::post(
        'leave-policies/status/{leavePolicy}',
        [LeavePolicyController::class, 'status']
    )->name('leave-policies.status');
    Route::resource('projects', ProjectController::class);

    Route::get(
        'role-permissions',
        [RolePermissionController::class, 'index']
    )->name('role-permissions.index');
    
    Route::get(
        'role-permissions/{role}',
        [RolePermissionController::class, 'edit']
    )->name('role-permissions.edit');
    
    Route::post(
        'role-permissions/{role}',
        [RolePermissionController::class, 'update']
    )->name('role-permissions.update');

    Route::get(
        'attendance',
        [AttendanceController::class, 'index']
    )->name('attendance.index');
    
    Route::post(
        'attendance/punch-in',
        [AttendanceController::class, 'punchIn']
    )->name('attendance.punchin');
    
    Route::post(
        'attendance/punch-out',
        [AttendanceController::class, 'punchOut']
    )->name('attendance.punchout');

    Route::get(
        'attendance/events',
        [AttendanceController::class, 'events']
    )->name('attendance.events');

    Route::get(
        'attendance/summary',
        [AttendanceController::class, 'summary']
    )->name('attendance.summary');

    Route::resource(
        'payrolls',
        PayrollController::class
    );
    
    Route::post(
        'payrolls/generate',
        [PayrollController::class, 'generatePayroll']
    )->name('payrolls.generate');
    
    Route::get(
        'payrolls/export/excel',
        [PayrollController::class, 'export']
    )->name('payrolls.export.excel');
    
    Route::get(
        'payrolls/payslip/{id}',
        [PayrollController::class, 'payslip']
    )->name('payrolls.payslip');
    
    Route::post(
        'payrolls/mark-paid/{id}',
        [PayrollController::class, 'markPaid']
    )->name('payrolls.markPaid');

    Route::resource(

        'leave-applications',
    
        LeaveApplicationController::class
    
    );
    
    Route::get(
    
        'leave-approvals',
    
        [LeaveApplicationController::class, 'approvals']
    
    )->name('leave-approvals.index');
    
    Route::post(
    
        'leave-approvals/{id}/approve',
    
        [LeaveApplicationController::class, 'approve']
    
    )->name('leave-approvals.approve');
    
    Route::post(
    
        'leave-approvals/{id}/reject',
    
        [LeaveApplicationController::class, 'reject']
    
    )->name('leave-approvals.reject');

    Route::resource(

        'daily-eod',
    
        DailyEodController::class
    
    );
    
    Route::post(
    
        '/daily-eod/{id}/review',
    
        [DailyEodController::class, 'review']
    
    )->name('daily-eod.review');

    Route::get(

        '/profile',
    
        [ProfileController::class, 'index']
    
    )->name('profile.index');
    
    Route::post(
    
        '/profile/update',
    
        [ProfileController::class, 'update']
    
    )->name('profile.update');
    
    Route::post(
    
        '/profile/change-password',
    
        [ProfileController::class, 'changePassword']
    
    )->name('profile.change-password');
});

Route::prefix('reports')
    ->group(function(){

        Route::get(

            '/dashboard',

            [ReportController::class, 'dashboard']

        )->name('reports.dashboard');

        Route::get(

            '/attendance',

            [ReportController::class, 'attendance']

        )->name('reports.attendance');

        Route::get(

            '/payroll',

            [ReportController::class, 'payroll']

        )->name('reports.payroll');

        Route::get(

            '/leaves',

            [ReportController::class, 'leaves']

        )->name('reports.leaves');

        Route::get(

            '/eod',

            [ReportController::class, 'eod']

        )->name('reports.eod');

        Route::get(

            '/department',

            [ReportController::class, 'department']

        )->name('reports.department');
        Route::post(

            '/profile/upload-document',
        
            [ProfileController::class, 'uploadDocument']
        
        )->name('profile.upload-document');

        Route::post(

            '/profile/update',
        
            [ProfileController::class, 'updateimage']
        
        )->name('profile.updateprofile');
        Route::get(

            '/users/{user}/documents',
        
            [UserController::class, 'documents']
        
        )->name('users.documents');
    });
require __DIR__.'/auth.php';