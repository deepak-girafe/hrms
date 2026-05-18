<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
      rel="stylesheet" />

<style>

.step-card {

    display: none;

}

.step-card.active {

    display: block;

}

.select2-container .select2-selection--multiple {

    min-height: 38px;

}

</style>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white">

        <h5 class="mb-0 fw-bold">

            {{ isset($user) ? 'Edit User' : 'Add User' }}

        </h5>

    </div>

    <div class="card-body">

        <form method="POST"
              id="multiStepForm"
              action="{{ isset($user)
                    ? route('users.update', $user->id)
                    : route('users.store') }}">

            @csrf

            @if(isset($user))
                @method('PUT')
            @endif

            <!-- STEP 1 -->

            <div class="step-card active"
                 data-step="1">

                <h5 class="fw-bold mb-4">

                    Basic Information

                </h5>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Full Name

                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name', $user->name ?? '') }}"
                               class="form-control required-field">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Email

                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email', $user->email ?? '') }}"
                               class="form-control required-field">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Mobile Number

                        </label>

                        <input type="text"
                               name="mobile_number"
                               value="{{ old('mobile_number', $user->mobile_number ?? '') }}"
                               class="form-control required-field">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Joining Date

                        </label>

                        <input type="date"
                               name="joining_date"
                               value="{{ old('joining_date', $user->joining_date ?? '') }}"
                               class="form-control required-field">

                    </div>

                </div>

            </div>

            <!-- STEP 2 -->

            <div class="step-card"
                 data-step="2">

                <h5 class="fw-bold mb-4">

                    Role & Department

                </h5>

                <div class="row">

                    <div class="col-md-6 mb-3">

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

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Designation

                        </label>

                        <input type="text"
                               name="designation"
                               value="{{ old('designation', $user->designation ?? '') }}"
                               class="form-control required-field">

                    </div>

                    <div class="col-md-6 mb-3">

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

                    <div class="col-md-6 mb-3"
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

            <!-- STEP 3 -->

            <div class="step-card"
                 data-step="3">

                <h5 class="fw-bold mb-4">

                    Salary Details

                </h5>

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Basic Salary

                        </label>

                        <input type="number"
                               step="0.01"
                               name="basic_salary"
                               class="form-control required-field">

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            HRA

                        </label>

                        <input type="number"
                               step="0.01"
                               name="hra"
                               class="form-control required-field">

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            DA

                        </label>

                        <input type="number"
                               step="0.01"
                               name="da"
                               class="form-control required-field">

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            TA

                        </label>

                        <input type="number"
                               step="0.01"
                               name="ta"
                               class="form-control required-field">

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Medical Allowance

                        </label>

                        <input type="number"
                               step="0.01"
                               name="medical_allowance"
                               class="form-control required-field">

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Bonus

                        </label>

                        <input type="number"
                               step="0.01"
                               name="bonus"
                               class="form-control required-field">

                    </div>

                </div>

            </div>

            <!-- STEP 4 -->

            <div class="step-card"
                 data-step="4">

                <h5 class="fw-bold mb-4">

                    Deductions & Status

                </h5>

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            PF Deduction

                        </label>

                        <input type="number"
                               step="0.01"
                               name="pf_deduction"
                               class="form-control required-field">

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            ESI Deduction

                        </label>

                        <input type="number"
                               step="0.01"
                               name="esi_deduction"
                               class="form-control required-field">

                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            TDS Deduction

                        </label>

                        <input type="number"
                               step="0.01"
                               name="tds_deduction"
                               class="form-control required-field">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select name="status"
                                class="form-select required-field">

                            <option value="">
                                Select Status
                            </option>

                            <option value="Active">
                                Active
                            </option>

                            <option value="Inactive">
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>

            </div>

            <!-- BUTTONS -->

            <div class="d-flex justify-content-between mt-4">

                <button type="button"
                        id="prevBtn"
                        class="btn btn-secondary rounded-pill px-4"
                        style="display:none;">

                    Previous

                </button>

                <button type="button"
                        id="nextBtn"
                        class="btn btn-primary rounded-pill px-4 ms-auto">

                    Next

                </button>

                <button type="submit"
                        id="submitBtn"
                        class="btn btn-success rounded-pill px-4"
                        style="display:none;">

                    {{ isset($user)
                        ? 'Update User'
                        : 'Save User' }}

                </button>

            </div>

        </form>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function () {

    $('.select2').select2({

        width: '100%'

    });

});

let currentStep = 1;

const totalSteps = 4;

function showStep(step) {

    $('.step-card').removeClass('active');

    $('.step-card[data-step="' + step + '"]')
        .addClass('active');

    if(step === 1) {

        $('#prevBtn').hide();

    } else {

        $('#prevBtn').show();

    }

    if(step === totalSteps) {

        $('#nextBtn').hide();

        $('#submitBtn').show();

    } else {

        $('#nextBtn').show();

        $('#submitBtn').hide();

    }
}

function validateStep(step) {

    let valid = true;

    $('.step-card[data-step="' + step + '"] .required-field').each(function () {

        if($(this).val() === '' || $(this).val() === null) {

            $(this).addClass('is-invalid');

            valid = false;

        } else {

            $(this).removeClass('is-invalid');

        }

    });

    return valid;
}

$('#nextBtn').click(function () {

    if(validateStep(currentStep)) {

        currentStep++;

        showStep(currentStep);

    }

});

$('#prevBtn').click(function () {

    currentStep--;

    showStep(currentStep);

});

showStep(currentStep);

const roleDropdown =
    document.getElementById('roleDropdown');

const reportingDiv =
    document.getElementById('reportingToDiv');

function toggleReporting() {

    const selectedOption =
        roleDropdown.options[roleDropdown.selectedIndex];

    const reportingRequired =
        selectedOption.getAttribute('data-reporting');

    if(reportingRequired === 'Yes') {

        reportingDiv.style.display = 'block';

    } else {

        reportingDiv.style.display = 'none';

    }
}

toggleReporting();

roleDropdown.addEventListener('change', toggleReporting);

</script>