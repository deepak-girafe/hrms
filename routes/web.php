<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
Route::redirect('/', '/login');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

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
});


require __DIR__.'/auth.php';