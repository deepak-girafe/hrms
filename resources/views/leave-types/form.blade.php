<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white">

        <h5 class="fw-bold mb-0">

            {{ isset($leaveType)
                ? 'Edit Leave Type'
                : 'Add Leave Type' }}

        </h5>

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ isset($leaveType)
                    ? route('leave-types.update', $leaveType->id)
                    : route('leave-types.store') }}">

            @csrf

            @if(isset($leaveType))
                @method('PUT')
            @endif

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Leave Name

                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $leaveType->name ?? '') }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Leave Code

                    </label>

                    <input type="text"
                           name="code"
                           value="{{ old('code', $leaveType->code ?? '') }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Paid Leave

                    </label>

                    <select name="paid"
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

                        Status

                    </label>

                    <select name="status"
                            class="form-select">

                        <option value="Active">

                            Active

                        </option>

                        <option value="Inactive">

                            Inactive

                        </option>

                    </select>

                </div>

            </div>

            <button type="submit"
                    class="btn btn-primary rounded-pill px-4">

                Save

            </button>

        </form>

    </div>

</div>