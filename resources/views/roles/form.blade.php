<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white">

        <h5 class="mb-0 fw-bold">

            {{ isset($role)
                ? 'Edit Role'
                : 'Add Role' }}

        </h5>

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ isset($role)
                    ? route('roles.update', $role->id)
                    : route('roles.store') }}">

            @csrf

            @if(isset($role))
                @method('PUT')
            @endif

            <div class="mb-3">

                <label class="form-label">

                    Role Name

                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name', $role->name ?? '') }}"
                       class="form-control"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Description

                </label>

                <textarea name="description"
                          class="form-control"
                          rows="3">{{ old('description', $role->description ?? '') }}</textarea>

            </div>
            <div class="mb-3">

                <label class="form-label">

                    Reporting Required

                </label>

                <select name="reporting_required"
                        class="form-select">

                    <option value="No"
                        {{ old('reporting_required', $role->reporting_required ?? '') == 'No' ? 'selected' : '' }}>

                        No

                    </option>

                    <option value="Yes"
                        {{ old('reporting_required', $role->reporting_required ?? '') == 'Yes' ? 'selected' : '' }}>

                        Yes

                    </option>

                </select>

            </div>

            <div class="mb-4">

                <label class="form-label">

                    Status

                </label>

                <select name="status"
                        class="form-select">

                    <option value="Active"
                        {{ old('status', $role->status ?? '') == 'Active' ? 'selected' : '' }}>

                        Active

                    </option>

                    <option value="Inactive"
                        {{ old('status', $role->status ?? '') == 'Inactive' ? 'selected' : '' }}>

                        Inactive

                    </option>

                </select>

            </div>

            <button type="submit"
                    class="btn btn-primary rounded-pill px-4">

                {{ isset($role)
                    ? 'Update Role'
                    : 'Save Role' }}

            </button>

        </form>

    </div>

</div>