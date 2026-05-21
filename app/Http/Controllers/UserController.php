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
//dd($users->toArray());
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

            /*
            |--------------------------------------------------------------------------
            | Basic Details
            |--------------------------------------------------------------------------
            */

            'employee_code' =>

                'required|string|max:50|unique:users,employee_code',

            'name' =>

                'required|string|max:255',

            'email' =>

                'required|email|max:255|unique:users,email',

            'mobile_number' =>

                'required|digits:10|unique:users,mobile_number',

            'joining_date' =>

                'required|date',

            'probation_period' =>

                'required|integer|min:0|max:24',

            /*
            |--------------------------------------------------------------------------
            | Organization
            |--------------------------------------------------------------------------
            */

            'role_id' =>

                'required|exists:roles,id',

            'designation' =>

                'required|string|max:255',

            'departments' =>

                'required|array|min:1',

            'departments.*' =>

                'exists:departments,id',

            /*
            |--------------------------------------------------------------------------
            | Reporting Managers
            |--------------------------------------------------------------------------
            */

            'reporting_to' =>

                'nullable|array',

            'reporting_to.*' =>

                'exists:users,id',

            /*
            |--------------------------------------------------------------------------
            | Salary
            |--------------------------------------------------------------------------
            */

            'basic_salary' =>

                'required|numeric|min:0',

            'hra' =>

                'required|numeric|min:0',

            'da' =>

                'required|numeric|min:0',

            'ta' =>

                'required|numeric|min:0',

            'medical_allowance' =>

                'nullable|numeric|min:0',

            'bonus' =>

                'nullable|numeric|min:0',

            'special_allowance' =>

                'nullable|numeric|min:0',

            /*
            |--------------------------------------------------------------------------
            | Deductions
            |--------------------------------------------------------------------------
            */

            'pf_deduction' =>

                'nullable|numeric|min:0',

            'esi_deduction' =>

                'nullable|numeric|min:0',

            'tds_deduction' =>

                'nullable|numeric|min:0',

            'loan_deduction' =>

                'nullable|numeric|min:0',

            'other_deduction' =>

                'nullable|numeric|min:0',

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'status' =>

                'required|in:Active,Inactive'

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

            'employee_code' =>
                $request->employee_code,

            'name' =>
                $request->name,

            'email' =>
                $request->email,

            'password' =>
                Hash::make($plainPassword),

            'role_id' =>
                $request->role_id,

            'designation' =>
                $request->designation,

            'mobile_number' =>
                $request->mobile_number,

            'joining_date' =>
                $request->joining_date,

            'probation_period' =>
                $request->probation_period,

            'status' =>
                $request->status,

            /*
            |--------------------------------------------------------------------------
            | Payroll Fields
            |--------------------------------------------------------------------------
            */

            'basic_salary' =>
                $request->basic_salary ?? 0,

            'hra' =>
                $request->hra ?? 0,

            'da' =>
                $request->da ?? 0,

            'ta' =>
                $request->ta ?? 0,

            'bonus' =>
                $request->bonus ?? 0,

            'incentive' =>
                $request->special_allowance ?? 0,

            'other_allowance' =>
                $request->medical_allowance ?? 0,

            'pf' =>
                $request->pf_deduction ?? 0,

            'esi' =>
                $request->esi_deduction ?? 0,

            'tds' =>
                $request->tds_deduction ?? 0,

            'professional_tax' =>
                $request->professional_tax ?? 0,

            'other_deduction' =>
                $request->other_deduction ?? 0

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

            ($request->bonus ?? 0) +

            ($request->special_allowance ?? 0);

        $totalDeduction =

            ($request->pf_deduction ?? 0) +

            ($request->esi_deduction ?? 0) +

            ($request->tds_deduction ?? 0) +

            ($request->loan_deduction ?? 0) +

            ($request->other_deduction ?? 0);

        $netSalary =

            $grossSalary - $totalDeduction;

        SalaryStructure::create([

            'user_id' => $user->id,

            'basic_salary' =>
                $request->basic_salary ?? 0,

            'hra' =>
                $request->hra ?? 0,

            'da' =>
                $request->da ?? 0,

            'ta' =>
                $request->ta ?? 0,

            'medical_allowance' =>
                $request->medical_allowance ?? 0,

            'bonus' =>
                $request->bonus ?? 0,

            'special_allowance' =>
                $request->special_allowance ?? 0,

            'pf_deduction' =>
                $request->pf ?? 0,

            'esi_deduction' =>
                $request->esi ?? 0,

            'tds_deduction' =>
                $request->tds ?? 0,

            'loan_deduction' =>
                $request->loan_deduction ?? 0,

            'other_deduction' =>
                $request->other_deduction ?? 0,

            'gross_salary' =>
                $grossSalary,

            'net_salary' =>
                $netSalary

        ]);

        /*
        |--------------------------------------------------------------------------
        | Send Welcome Mail
        |--------------------------------------------------------------------------
        */

        try {

            Mail::to($user->email)
                ->send(
                    new WelcomeUserMail(
                        $user,
                        $plainPassword
                    )
                );

        } catch (\Exception $e) {

            \Log::error($e->getMessage());
        }

        return redirect()

            ->route('users.index')

            ->with(

                'success',

                'Employee created successfully'

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

            /*
            |--------------------------------------------------------------------------
            | Basic Details
            |--------------------------------------------------------------------------
            */

            'employee_code' =>

                'required|string|max:50|unique:users,employee_code,' . $user->id,

            'name' =>

                'required|string|max:255',

            'email' =>

                'required|email|max:255|unique:users,email,' . $user->id,

            'mobile_number' =>

                'required|digits:10|unique:users,mobile_number,' . $user->id,

            'joining_date' =>

                'required|date',

            'probation_period' =>

                'required|integer|min:0|max:24',

            /*
            |--------------------------------------------------------------------------
            | Organization
            |--------------------------------------------------------------------------
            */

            'role_id' =>

                'required|exists:roles,id',

            'designation' =>

                'required|string|max:255',

            'departments' =>

                'required|array|min:1',

            'departments.*' =>

                'exists:departments,id',

            /*
            |--------------------------------------------------------------------------
            | Reporting Managers
            |--------------------------------------------------------------------------
            */

            'reporting_to' =>

                'nullable|array',

            'reporting_to.*' =>

                'exists:users,id',

            /*
            |--------------------------------------------------------------------------
            | Salary
            |--------------------------------------------------------------------------
            */

            'basic_salary' =>

                'required|numeric|min:0',

            'hra' =>

                'required|numeric|min:0',

            'da' =>

                'required|numeric|min:0',

            'ta' =>

                'required|numeric|min:0',

            'medical_allowance' =>

                'nullable|numeric|min:0',

            'bonus' =>

                'nullable|numeric|min:0',

            'special_allowance' =>

                'nullable|numeric|min:0',

            /*
            |--------------------------------------------------------------------------
            | Deductions
            |--------------------------------------------------------------------------
            */

            'pf_deduction' =>

                'nullable|numeric|min:0',

            'esi_deduction' =>

                'nullable|numeric|min:0',

            'tds_deduction' =>

                'nullable|numeric|min:0',

            'loan_deduction' =>

                'nullable|numeric|min:0',

            'other_deduction' =>

                'nullable|numeric|min:0',

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'status' =>

                'required|in:Active,Inactive'

        ]);

        /*
        |--------------------------------------------------------------------------
        | Update User
        |--------------------------------------------------------------------------
        */

        $user->update([

            'employee_code' =>
                $request->employee_code,

            'name' =>
                $request->name,

            'email' =>
                $request->email,

            'role_id' =>
                $request->role_id,

            'designation' =>
                $request->designation,

            'mobile_number' =>
                $request->mobile_number,

            'joining_date' =>
                $request->joining_date,

            'probation_period' =>
                $request->probation_period,

            'status' =>
                $request->status,

            /*
            |--------------------------------------------------------------------------
            | Payroll Fields
            |--------------------------------------------------------------------------
            */

            'basic_salary' =>
                $request->basic_salary ?? 0,

            'hra' =>
                $request->hra ?? 0,

            'da' =>
                $request->da ?? 0,

            'ta' =>
                $request->ta ?? 0,

            'bonus' =>
                $request->bonus ?? 0,

            'incentive' =>
                $request->special_allowance ?? 0,

            'other_allowance' =>
                $request->medical_allowance ?? 0,

            'pf' =>
                $request->pf_deduction ?? 0,

            'esi' =>
                $request->esi_deduction ?? 0,

            'tds' =>
                $request->tds_deduction ?? 0,

            'professional_tax' =>
                $request->professional_tax ?? 0,

            'other_deduction' =>
                $request->other_deduction ?? 0

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

            ($request->bonus ?? 0) +

            ($request->special_allowance ?? 0);

        $totalDeduction =

            ($request->pf_deduction ?? 0) +

            ($request->esi_deduction ?? 0) +

            ($request->tds_deduction ?? 0) +

            ($request->loan_deduction ?? 0) +

            ($request->other_deduction ?? 0);

        $netSalary =

            $grossSalary - $totalDeduction;

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

                'basic_salary' =>
                    $request->basic_salary ?? 0,

                'hra' =>
                    $request->hra ?? 0,

                'da' =>
                    $request->da ?? 0,

                'ta' =>
                    $request->ta ?? 0,

                'medical_allowance' =>
                    $request->medical_allowance ?? 0,

                'bonus' =>
                    $request->bonus ?? 0,

                'special_allowance' =>
                    $request->special_allowance ?? 0,

                'pf_deduction' =>
                    $request->pf ?? 0,

                'esi_deduction' =>
                    $request->esi?? 0,

                'tds_deduction' =>
                    $request->tds ?? 0,

                'loan_deduction' =>
                    $request->loan_deduction ?? 0,

                'other_deduction' =>
                    $request->other_deduction ?? 0,

                'gross_salary' =>
                    $grossSalary,

                'net_salary' =>
                    $netSalary

            ]

        );

        return redirect()

            ->route('users.index')

            ->with(

                'success',

                'Employee updated successfully'

            );
    }
}