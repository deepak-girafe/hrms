<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white">

        <h5 class="fw-bold mb-0">

            Leave Policy

        </h5>

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ isset($leavePolicy)
                    ? route('leave-policies.update', $leavePolicy->id)
                    : route('leave-policies.store') }}">

            @csrf

            @if(isset($leavePolicy))
                @method('PUT')
            @endif

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Role

                    </label>

                    <select name="role_id"
                            class="form-select">

                        @foreach($roles as $role)

                            <option value="{{ $role->id }}">

                                {{ $role->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Leave Type

                    </label>

                    <select name="leave_type_id"
                            class="form-select">

                        @foreach($leaveTypes as $leaveType)

                            <option value="{{ $leaveType->id }}">

                                {{ $leaveType->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Employment Type

                    </label>

                    <select name="employment_type"
                            class="form-select">

                        <option value="Probation">

                            Probation

                        </option>

                        <option value="Permanent">

                            Permanent

                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Allowed Leaves

                    </label>

                    <input type="number"
                           name="allowed_leaves"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Leave Cycle

                    </label>

                    <select name="leave_cycle"
                            class="form-select">

                        <option value="Monthly">

                            Monthly

                        </option>

                        <option value="Yearly">

                            Yearly

                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Carry Forward

                    </label>

                    <select name="carry_forward"
                            class="form-select">

                        <option value="Yes">

                            Yes

                        </option>

                        <option value="No">

                            No

                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Max Carry Forward

                    </label>

                    <input type="number"
                           name="max_carry_forward"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Sandwich Policy

                    </label>

                    <select name="sandwich_policy"
                            class="form-select">

                        <option value="Yes">

                            Yes

                        </option>

                        <option value="No">

                            No

                        </option>

                    </select>

                </div>

            </div>

            <button type="submit"
                    class="btn btn-primary rounded-pill px-4">

                Save Policy

            </button>

        </form>

    </div>

</div>