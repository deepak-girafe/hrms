<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\SalaryStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;

class UserController extends Controller
{
    /**
     * Users list
     */
    public function index()
    {
        $users = User::with([
                'role',
                'departments',
                'reportingManagers'
            ])
            ->latest()
            ->get();

        return view('users.index', compact('users'));
    }

    /**
     * Create page
     */
    public function create()
    {
        $roles = Role::where('status', 'Active')
            ->get();

        $departments = Department::where('status', 'Active')
            ->get();

        $managers = User::where('status', 'Active')
            ->get();

        return view('users.create', compact(
            'roles',
            'departments',
            'managers'
        ));
    }

    /**
     * Store user
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',
            'email' => 'required|email|unique:users,email'

        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate Password
        |--------------------------------------------------------------------------
        */

        $plainPassword = Str::random(8);

        /*
        |--------------------------------------------------------------------------
        | Create User
        |--------------------------------------------------------------------------
        */

        $user = User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($plainPassword),

            'role_id' => $request->role_id,

            'designation' => $request->designation,

            'mobile_number' => $request->mobile_number,

            'joining_date' => $request->joining_date,

            'status' => $request->status

        ]);

        /*
        |--------------------------------------------------------------------------
        | Departments
        |--------------------------------------------------------------------------
        */

        if ($request->departments) {

            $user->departments()
                ->sync($request->departments);
        }

        /*
        |--------------------------------------------------------------------------
        | Reporting Managers
        |--------------------------------------------------------------------------
        */

        if ($request->reporting_to) {

            $user->reportingManagers()
                ->sync($request->reporting_to);
        }

        /*
        |--------------------------------------------------------------------------
        | Salary Structure
        |--------------------------------------------------------------------------
        */

        $grossSalary =

            ($request->basic_salary ?? 0) +
            ($request->hra ?? 0) +
            ($request->da ?? 0) +
            ($request->ta ?? 0) +
            ($request->medical_allowance ?? 0) +
            ($request->bonus ?? 0);

        $totalDeduction =

            ($request->pf_deduction ?? 0) +
            ($request->esi_deduction ?? 0) +
            ($request->tds_deduction ?? 0) +
            ($request->loan_deduction ?? 0) +
            ($request->other_deduction ?? 0);

        $netSalary = $grossSalary - $totalDeduction;

        SalaryStructure::create([

            'user_id' => $user->id,

            'basic_salary' => $request->basic_salary ?? 0,

            'hra' => $request->hra ?? 0,

            'da' => $request->da ?? 0,

            'ta' => $request->ta ?? 0,

            'medical_allowance' => $request->medical_allowance ?? 0,

            'bonus' => $request->bonus ?? 0,

            'special_allowance' => $request->special_allowance ?? 0,

            'pf_deduction' => $request->pf_deduction ?? 0,

            'esi_deduction' => $request->esi_deduction ?? 0,

            'tds_deduction' => $request->tds_deduction ?? 0,

            'loan_deduction' => $request->loan_deduction ?? 0,

            'other_deduction' => $request->other_deduction ?? 0,

            'gross_salary' => $grossSalary,

            'net_salary' => $netSalary

        ]);

        /*
        |--------------------------------------------------------------------------
        | Send Welcome Mail
        |--------------------------------------------------------------------------
        */

        Mail::to($user->email)
            ->send(new WelcomeUserMail($user, $plainPassword));

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User added successfully and welcome email sent'
            );
    }

    /**
     * Edit page
     */
    public function edit(User $user)
    {
        $roles = Role::where('status', 'Active')
            ->get();

        $departments = Department::where('status', 'Active')
            ->get();

        $managers = User::where('status', 'Active')
            ->where('id', '!=', $user->id)
            ->get();

        $user->load([
            'departments',
            'reportingManagers',
            'salaryStructure'
        ]);

        return view('users.edit', compact(
            'user',
            'roles',
            'departments',
            'managers'
        ));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([

            'name' => 'required',

            'email' => 'required|email|unique:users,email,' . $user->id

        ]);

        /*
        |--------------------------------------------------------------------------
        | Update User
        |--------------------------------------------------------------------------
        */

        $user->update([

            'name' => $request->name,

            'email' => $request->email,

            'role_id' => $request->role_id,

            'designation' => $request->designation,

            'mobile_number' => $request->mobile_number,

            'joining_date' => $request->joining_date,

            'status' => $request->status

        ]);

        /*
        |--------------------------------------------------------------------------
        | Departments
        |--------------------------------------------------------------------------
        */

        $user->departments()
            ->sync($request->departments ?? []);

        /*
        |--------------------------------------------------------------------------
        | Reporting Managers
        |--------------------------------------------------------------------------
        */

        $user->reportingManagers()
            ->sync($request->reporting_to ?? []);

        /*
        |--------------------------------------------------------------------------
        | Salary Calculations
        |--------------------------------------------------------------------------
        */

        $grossSalary =

            ($request->basic_salary ?? 0) +
            ($request->hra ?? 0) +
            ($request->da ?? 0) +
            ($request->ta ?? 0) +
            ($request->medical_allowance ?? 0) +
            ($request->bonus ?? 0);

        $totalDeduction =

            ($request->pf_deduction ?? 0) +
            ($request->esi_deduction ?? 0) +
            ($request->tds_deduction ?? 0) +
            ($request->loan_deduction ?? 0) +
            ($request->other_deduction ?? 0);

        $netSalary = $grossSalary - $totalDeduction;

        /*
        |--------------------------------------------------------------------------
        | Salary Structure
        |--------------------------------------------------------------------------
        */

        SalaryStructure::updateOrCreate(

            [
                'user_id' => $user->id
            ],

            [

                'basic_salary' => $request->basic_salary ?? 0,

                'hra' => $request->hra ?? 0,

                'da' => $request->da ?? 0,

                'ta' => $request->ta ?? 0,

                'medical_allowance' => $request->medical_allowance ?? 0,

                'bonus' => $request->bonus ?? 0,

                'special_allowance' => $request->special_allowance ?? 0,

                'pf_deduction' => $request->pf_deduction ?? 0,

                'esi_deduction' => $request->esi_deduction ?? 0,

                'tds_deduction' => $request->tds_deduction ?? 0,

                'loan_deduction' => $request->loan_deduction ?? 0,

                'other_deduction' => $request->other_deduction ?? 0,

                'gross_salary' => $grossSalary,

                'net_salary' => $netSalary

            ]

        );

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User updated successfully'
            );
    }
}