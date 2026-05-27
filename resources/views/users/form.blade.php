<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
      rel="stylesheet" />

<style>

body{
    background:#f4f7fb;
}

.form-wizard-card{

    border:none;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 10px 35px rgba(0,0,0,0.08);
}

.form-header{

    background:linear-gradient(
        135deg,
        #0d6efd,
        #0b5ed7
    );

    color:#fff;
    padding:30px;
}

.form-header h3{

    font-weight:700;
    margin-bottom:5px;
}

.form-header p{

    margin-bottom:0;
    opacity:.9;
}

.step-indicator{

    display:flex;
    justify-content:space-between;
    margin-bottom:35px;
    position:relative;
}

.step-indicator::before{

    content:'';
    position:absolute;
    top:22px;
    left:0;
    width:100%;
    height:4px;
    background:#e9ecef;
    z-index:1;
}

.step-item{

    position:relative;
    z-index:2;
    text-align:center;
    width:100%;
}

.step-circle{

    width:45px;
    height:45px;
    border-radius:50%;
    background:#dee2e6;
    color:#6c757d;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    font-weight:700;
    transition:.3s;
}

.step-item.active .step-circle{

    background:#0d6efd;
    color:#fff;
    box-shadow:0 5px 15px rgba(13,110,253,.3);
}

.step-title{

    margin-top:10px;
    font-size:13px;
    font-weight:600;
    color:#6c757d;
}

.step-item.active .step-title{

    color:#0d6efd;
}

.step-card{

    display:none;
    animation:fadeIn .3s ease;
}

.step-card.active{

    display:block;
}

@keyframes fadeIn{

    from{
        opacity:0;
        transform:translateY(10px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

.form-section{

    background:#fff;
    border-radius:18px;
    padding:25px;
    border:1px solid #eef1f6;
}

.form-section-title{

    font-size:18px;
    font-weight:700;
    margin-bottom:25px;
    color:#212529;
}

.form-label{

    font-weight:600;
    margin-bottom:8px;
    color:#495057;
}

.form-control,
.form-select{

    border-radius:12px;
    min-height:48px;
    border:1px solid #dbe2ea;
    box-shadow:none !important;
}

.form-control:focus,
.form-select:focus{

    border-color:#0d6efd;
}

.select2-container--default .select2-selection--multiple{

    border-radius:12px !important;
    border:1px solid #dbe2ea !important;
    min-height:48px !important;
    padding:5px;
}

.select2-container--default.select2-container--focus
.select2-selection--multiple{

    border-color:#0d6efd !important;
}

.step-actions{

    border-top:1px solid #eef1f6;
    padding-top:25px;
}

.btn-custom{

    min-width:140px;
    min-height:48px;
    border-radius:14px;
    font-weight:600;
}

.salary-card{

    background:#f8fbff;
    border:1px solid #e1ecff;
    border-radius:16px;
    padding:20px;
}

.is-invalid{

    border-color:#dc3545 !important;
}

</style>

<div class="container-fluid py-4">

    <div class="card form-wizard-card">

        <div class="form-header">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h3>

                        {{ isset($user)
                            ? 'Edit Employee'
                            : 'Create Employee' }}

                    </h3>

                    <p>

                        Manage employee details, salary and organization setup

                    </p>

                </div>

                <div>

                    <i class="bi bi-person-workspace"
                       style="font-size:55px;"></i>

                </div>

            </div>

        </div>

        <div class="card-body p-4 p-lg-5">

            {{-- STEP INDICATOR --}}

            <div class="step-indicator">

                <div class="step-item active"
                     data-indicator="1">

                    <div class="step-circle">

                        1

                    </div>

                    <div class="step-title">

                        Basic

                    </div>

                </div>

                <div class="step-item"
                     data-indicator="2">

                    <div class="step-circle">

                        2

                    </div>

                    <div class="step-title">

                        Organization

                    </div>

                </div>

                <div class="step-item"
                     data-indicator="3">

                    <div class="step-circle">

                        3

                    </div>

                    <div class="step-title">

                        Salary

                    </div>

                </div>

                <div class="step-item"
                     data-indicator="4">

                    <div class="step-circle">

                        4

                    </div>

                    <div class="step-title">

                        Deductions

                    </div>

                </div>

            </div>

            <form method="POST"
                  id="multiStepForm"
                  action="{{ isset($user)
                        ? route('users.update', $user->id)
                        : route('users.store') }}">

                @csrf

                @if(isset($user))
                    @method('PUT')
                @endif

                {{-- STEP 1 --}}

                <div class="step-card active"
                     data-step="1">

                    <div class="form-section">

                        <h5 class="form-section-title">

                            Basic Information

                        </h5>

                        <div class="row">

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Employee Code

                                </label>

                                <input type="text"
                                    name="employee_code"
                                    id="employee_code"
                                    value="{{ old('employee_code', $user->employee_code ?? '') }}"
                                    class="form-control required-field"
                                    placeholder="EMP-1001">
                                <small class="text-danger" id="employee_code_error"></small>

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Full Name

                                </label>

                                <input type="text"
                                       name="name"
                                       value="{{ old('name', $user->name ?? '') }}"
                                       class="form-control required-field">

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Email

                                </label>

                                <input type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email', $user->email ?? '') }}"
                                    class="form-control required-field"
                                    placeholder="example@gmail.com">

                                <small class="text-danger" id="email_error"></small>

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Mobile Number

                                </label>

                                <input type="text"
                                    name="mobile_number"
                                    id="mobile_number"
                                    value="{{ old('mobile_number', $user->mobile_number ?? '') }}"
                                    class="form-control required-field"
                                    maxlength="10"
                                    placeholder="9876543210">

                                <small class="text-danger" id="mobile_error"></small>

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Joining Date

                                </label>

                                <input type="date"
                                       name="joining_date"
                                       value="{{ old('joining_date', $user->joining_date ?? '') }}"
                                       class="form-control required-field">

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Probation Period (Months)

                                </label>

                                <input type="number"
                                       name="probation_period"
                                       value="{{ old('probation_period', $user->probation_period ?? 6) }}"
                                       class="form-control required-field">

                            </div>

                        </div>

                    </div>

                </div>

                {{-- STEP 2 --}}

                <div class="step-card"
                     data-step="2">

                    <div class="form-section">

                        <h5 class="form-section-title">

                            Organization Structure

                        </h5>

                        <div class="row">

                            <div class="col-md-6 mb-4">

                                <label class="form-label">

                                    Role

                                </label>

                                <select name="role_id"
                                        id="roleDropdown"
                                        class="form-select required-field">

                                    <option value="">
                                        Select Role
                                    </option>

                                    @foreach($roles as $role)

                                        <option value="{{ $role->id }}"
                                                data-reporting="{{ $role->reporting_required }}"
                                            {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>

                                            {{ $role->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label">

                                    Designation

                                </label>

                                <input type="text"
                                       name="designation"
                                       value="{{ old('designation', $user->designation ?? '') }}"
                                       class="form-control required-field">

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label">

                                    Departments

                                </label>

                                <select name="departments[]"
                                        class="form-select select2 required-field"
                                        multiple>

                                    @foreach($departments as $department)

                                        <option value="{{ $department->id }}"

                                            @if(isset($user) &&
                                                $user->departments
                                                    ->pluck('id')
                                                    ->contains($department->id))
                                                selected
                                            @endif>

                                            {{ $department->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-6 mb-4"
                                 id="reportingToDiv"
                                 style="display:none;">

                                <label class="form-label">

                                    Reporting Managers

                                </label>

                                <select name="reporting_to[]"
                                        class="form-select select2"
                                        multiple>

                                    @foreach($managers as $manager)

                                        <option value="{{ $manager->id }}"

                                            @if(isset($user) &&
                                                $user->reportingManagers
                                                    ->pluck('id')
                                                    ->contains($manager->id))
                                                selected
                                            @endif>

                                            {{ $manager->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- STEP 3 --}}

                <div class="step-card"
                     data-step="3">

                    <div class="salary-card">

                        <h5 class="form-section-title">

                            Salary Structure

                        </h5>

                        <div class="row">

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Basic Salary

                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="basic_salary"
                                       value="{{ old('basic_salary', $user->salaryStructure->basic_salary ?? '') }}"
                                       class="form-control required-field">

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    HRA

                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="hra"
                                       value="{{ old('hra', $user->salaryStructure->hra ?? '') }}"
                                       class="form-control required-field">

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    DA

                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="da"
                                       value="{{ old('da', $user->salaryStructure->da ?? '') }}"
                                       class="form-control required-field">

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    TA

                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="ta"
                                       value="{{ old('ta', $user->salaryStructure->ta ?? '') }}"
                                       class="form-control required-field">

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Bonus

                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="bonus"
                                       value="{{ old('bonus', $user->salaryStructure->bonus ?? '') }}"
                                       class="form-control required-field">

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Incentive

                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="special_allowance"
                                       value="{{ old('special_allowance', $user->salaryStructure->special_allowance ?? '') }}"
                                       class="form-control required-field">

                            </div>

                        </div>

                    </div>

                </div>

                {{-- STEP 4 --}}

                <div class="step-card"
                     data-step="4">

                    <div class="salary-card">

                        <h5 class="form-section-title">

                            Deductions & Status

                        </h5>

                        <div class="row">

                            <div class="col-md-3 mb-4">

                                <label class="form-label">

                                    PF

                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="pf"
                                       value="{{ old('pf', $user->salaryStructure->pf_deduction ?? '') }}"
                                       class="form-control required-field">

                            </div>

                            <div class="col-md-3 mb-4">

                                <label class="form-label">

                                    ESI

                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="esi"
                                       value="{{ old('esi', $user->salaryStructure->esi_deduction ?? '') }}"
                                       class="form-control required-field">

                            </div>

                            <div class="col-md-3 mb-4">

                                <label class="form-label">

                                    TDS

                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="tds"
                                       value="{{ old('tds', $user->salaryStructure->tds_deduction ?? '') }}"
                                       class="form-control required-field">

                            </div>

                            <!-- <div class="col-md-3 mb-4">

                                <label class="form-label">

                                    Professional Tax

                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="professional_tax"
                                       value="{{ old('professional_tax', $user->salaryStructure->professional_tax ?? '') }}"
                                       class="form-control required-field">

                            </div> -->

                            <div class="col-md-6 mb-4">

                                <label class="form-label">

                                    Status

                                </label>

                                <select name="status"
                                        class="form-select required-field">

                                    <option value="">
                                        Select Status
                                    </option>

                                    <option value="Active"
                                        {{ old('status', $user->status ?? '') == 'Active' ? 'selected' : '' }}>

                                        Active

                                    </option>

                                    <option value="Inactive"
                                        {{ old('status', $user->status ?? '') == 'Inactive' ? 'selected' : '' }}>

                                        Inactive

                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ACTIONS --}}

                <div class="step-actions d-flex justify-content-between mt-4">

                    <button type="button"
                            id="prevBtn"
                            class="btn btn-light btn-custom"
                            style="display:none;">

                        <i class="bi bi-arrow-left me-2"></i>

                        Previous

                    </button>

                    <button type="button"
                            id="nextBtn"
                            class="btn btn-primary btn-custom ms-auto">

                        Next

                        <i class="bi bi-arrow-right ms-2"></i>

                    </button>

                    <button type="submit"
                            id="submitBtn"
                            class="btn btn-success btn-custom"
                            style="display:none;">

                        <i class="bi bi-check-circle me-2"></i>

                        {{ isset($user)
                            ? 'Update Employee'
                            : 'Save Employee' }}

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function () {

    $('.select2').select2({

        width:'100%',

        placeholder:'Select Options'

    });

});

let currentStep = 1;

const totalSteps = 4;

function showStep(step) {

    $('.step-card').removeClass('active');

    $('.step-card[data-step="' + step + '"]')
        .addClass('active');

    $('.step-item').removeClass('active');

    $('.step-item[data-indicator="' + step + '"]')
        .addClass('active');

    if(step === 1){

        $('#prevBtn').hide();

    } else {

        $('#prevBtn').show();

    }

    if(step === totalSteps){

        $('#nextBtn').hide();

        $('#submitBtn').show();

    } else {

        $('#nextBtn').show();

        $('#submitBtn').hide();

    }
}

function validateStep(step){

    let valid = true;

    $('.step-card[data-step="' + step + '"] .required-field').each(function(){

        if($(this).val() == '' || $(this).val() == null){

            $(this).addClass('is-invalid');

            valid = false;

        } else {

            $(this).removeClass('is-invalid');
        }
    });

    return valid;
}

$('#nextBtn').click(function(){

    if(validateStep(currentStep)){

        currentStep++;

        showStep(currentStep);
    }
});

$('#prevBtn').click(function(){

    currentStep--;

    showStep(currentStep);
});

showStep(currentStep);

const roleDropdown =
    document.getElementById('roleDropdown');

const reportingDiv =
    document.getElementById('reportingToDiv');

function toggleReporting(){

    const selectedOption =
        roleDropdown.options[
            roleDropdown.selectedIndex
        ];

    const reportingRequired =
        selectedOption.getAttribute(
            'data-reporting'
        );

    if(reportingRequired === 'Yes'){

        reportingDiv.style.display = 'block';

    } else {

        reportingDiv.style.display = 'none';
    }
}

toggleReporting();

roleDropdown.addEventListener(
    'change',
    toggleReporting
);

</script>

<script>
$(document).ready(function () {

    $('#employee_code').on('keyup blur', function () {

        let employee_code = $(this).val();

        if(employee_code == ''){
            $('#employee_code_error').text('');
            return;
        }

        $.ajax({
            url: "{{ route('users.check-employee-code') }}",
            type: "POST",
            data: {
                employee_code: employee_code,
                user_id: "{{ $user->id ?? '' }}",
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {

                if(response.exists){
                    $('#employee_code_error').text('Employee code already exists');
                    $('#employee_code').addClass('is-invalid');
                    $('#employee_code').val('');
                    $('#employee_code').focus();
                } else {
                    $('#employee_code_error').text('');
                    $('#employee_code').removeClass('is-invalid');
                }

            }
        });

    });

});
</script>

<script>
$(document).ready(function () {

    $('#email').on('change', function () {

        let email = $(this).val();

        // Email regex
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Empty check
        if(email == ''){
            $('#email_error').text('');
            $('#email').removeClass('is-invalid');
            return;
        }

        // Format check
        if(!emailPattern.test(email)){
            $('#email_error').text('Please enter valid email address');
            $('#email').addClass('is-invalid');
            $('#email').val('');  
            $('#email').focus();  
            return;
        }

        $.ajax({
            url: "{{ route('check.email') }}",
            type: "POST",
            data: {
                email: email,
                user_id: "{{ $user->id ?? '' }}",
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {

                if(response.exists){
                    $('#email_error').text('Email already exists');
                    $('#email').addClass('is-invalid');
                    
                    $('#email').val('');  
                    $('#email').focus();  
                } else {
                    $('#email_error').text('');
                    $('#email').removeClass('is-invalid');
                   
                }

            }
        });

    });

});
</script>
<script>
$(document).ready(function () {

    $('#mobile_number').on('change', function () {

        // Allow only numeric
        this.value = this.value.replace(/\D/g, '');

        let mobile = $(this).val();

        // Empty check
        if(mobile == ''){
            $('#mobile_error').text('');
            $('#mobile_number').removeClass('is-invalid');
            return;
        }

        // Length check
        if(mobile.length < 10){
            $('#mobile_error').text('Mobile number must be 10 digits');
            $('#mobile_number').addClass('is-invalid');
           // $('button[type="submit"]').prop('disabled', true);
            $('#mobile_number').val('');  
                    $('#mobile_number').focus();
            return;
        }

        // AJAX unique check
        $.ajax({
            url: "{{ route('check.mobile') }}",
            type: "POST",
            data: {
                mobile_number: mobile,
                user_id: "{{ $user->id ?? '' }}",
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {

                if(response.exists){

                    $('#mobile_error').text('Mobile number already exists');
                    $('#mobile_number').addClass('is-invalid');
                    $('#mobile_number').val('');  
                    $('#mobile_number').focus();  

                } else {

                    $('#mobile_error').text('');
                    $('#mobile_number').removeClass('is-invalid');
                   

                }

            }
        });

    });

});
</script>