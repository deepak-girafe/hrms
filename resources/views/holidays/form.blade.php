<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white">

        <h5 class="mb-0 fw-bold">

            {{ isset($holiday)
                ? 'Edit Holiday'
                : 'Add Holiday' }}

        </h5>

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ isset($holiday)
                    ? route('holidays.update', $holiday->id)
                    : route('holidays.store') }}">

            @csrf

            @if(isset($holiday))
                @method('PUT')
            @endif

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Holiday Name

                    </label>

                    <input type="text"
                           name="title"
                           value="{{ old('title', $holiday->title ?? '') }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Holiday Date

                    </label>

                    <input type="date"
                           name="holiday_date"
                           value="{{ old('holiday_date', $holiday->holiday_date ?? '') }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Holiday Type

                    </label>

                    <select name="holiday_type"
                            class="form-select">

                        <option value="Gazetted">

                            Gazetted

                        </option>

                        <option value="Restricted">

                            Restricted

                        </option>

                        <option value="Optional">

                            Optional

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

                <div class="col-12 mb-4">

                    <label class="form-label">

                        Description

                    </label>

                    <textarea name="description"
                              class="form-control"
                              rows="3">{{ old('description', $holiday->description ?? '') }}</textarea>

                </div>

            </div>

            <button type="submit"
                    class="btn btn-primary rounded-pill px-4">

                {{ isset($holiday)
                    ? 'Update Holiday'
                    : 'Save Holiday' }}

            </button>

        </form>

    </div>

</div>