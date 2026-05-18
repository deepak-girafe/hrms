<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white">

        <h5 class="mb-0 fw-bold">

            {{ isset($department)
                ? 'Edit Department'
                : 'Add Department' }}

        </h5>

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ isset($department)
                    ? route('departments.update', $department->id)
                    : route('departments.store') }}">

            @csrf

            @if(isset($department))
                @method('PUT')
            @endif

            <div class="mb-3">

                <label class="form-label">

                    Department Name

                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name', $department->name ?? '') }}"
                       class="form-control"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Description

                </label>

                <textarea name="description"
                          class="form-control"
                          rows="3">{{ old('description', $department->description ?? '') }}</textarea>

            </div>

            <div class="mb-4">

                <label class="form-label">

                    Status

                </label>

                <select name="status"
                        class="form-select">

                    <option value="Active"
                        {{ old('status', $department->status ?? '') == 'Active' ? 'selected' : '' }}>

                        Active

                    </option>

                    <option value="Inactive"
                        {{ old('status', $department->status ?? '') == 'Inactive' ? 'selected' : '' }}>

                        Inactive

                    </option>

                </select>

            </div>

            <button type="submit"
                    class="btn btn-primary rounded-pill px-4">

                {{ isset($department)
                    ? 'Update Department'
                    : 'Save Department' }}

            </button>

        </form>

    </div>

</div>