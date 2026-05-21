@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow rounded-4">

        <div class="card-header bg-white py-3">

            <h4 class="fw-bold mb-0">

                Apply Leave

            </h4>

        </div>

        <div class="card-body p-4">

            @if(session('error'))

                <div class="alert alert-danger">

                    {{ session('error') }}

                </div>

            @endif

            <form method="POST"
                  action="{{ route('leave-applications.store') }}">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">

                            Leave Type

                        </label>

                        <select name="leave_type_id"
                                class="form-select select2"
                                required>

                            <option value="">

                                Select Leave Type

                            </option>

                            @foreach($leaveTypes as $type)

                                <option value="{{ $type->id }}">

                                    {{ $type->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3 mb-4">

                        <label class="form-label fw-semibold">

                            From Date

                        </label>

                        <input type="date"
                               name="from_date"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-3 mb-4">

                        <label class="form-label fw-semibold">

                            To Date

                        </label>

                        <input type="date"
                               name="to_date"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-12 mb-4">

                        <label class="form-label fw-semibold">

                            Reason

                        </label>

                        <textarea name="reason"
                                  rows="5"
                                  class="form-control"
                                  required></textarea>

                    </div>

                </div>

                <button type="submit"
                        class="btn btn-primary rounded-pill px-4">

                    Apply Leave

                </button>

            </form>

        </div>

    </div>

</div>

@endsection