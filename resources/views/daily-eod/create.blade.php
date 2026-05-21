@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h3 class="fw-bold mb-1">

                        Submit Daily EOD

                    </h3>

                    <p class="text-muted mb-0">

                        Submit today's work updates

                    </p>

                </div>

                <a href="{{ route('daily-eod.index') }}"
                   class="btn btn-light rounded-pill px-4">

                    Back

                </a>

            </div>

        </div>

        <div class="card-body p-4">

            @if(session('error'))

                <div class="alert alert-danger rounded-4">

                    {{ session('error') }}

                </div>

            @endif

            <form method="POST"
                  action="{{ route('daily-eod.store') }}">

                @csrf

                <div id="eodItems">

                    <div class="eod-item border rounded-4 p-4 mb-4 bg-light">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">

                                    Project

                                </label>

                                <select name="project_id[]"
                                        class="form-select rounded-3"
                                        required>

                                    <option value="">

                                        Select Project

                                    </option>

                                    @foreach($projects as $project)

                                        <option value="{{ $project->id }}">

                                            {{ $project->project_name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-6 mb-3 d-flex align-items-end justify-content-end">

                                <button type="button"
                                        class="btn btn-danger rounded-pill removeItem">

                                    Remove

                                </button>

                            </div>

                            <div class="col-12 mb-3">

                                <label class="form-label fw-semibold">

                                    Work Done

                                </label>

                                <textarea name="work_done[]"
                                          rows="5"
                                          class="form-control rounded-3"
                                          placeholder="Describe completed work..."
                                          required></textarea>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">

                                    Blockers

                                </label>

                                <textarea name="blockers[]"
                                          rows="4"
                                          class="form-control rounded-3"
                                          placeholder="Any blockers or issues"></textarea>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">

                                    Tomorrow Plan

                                </label>

                                <textarea name="tomorrow_plan[]"
                                          rows="4"
                                          class="form-control rounded-3"
                                          placeholder="Tomorrow's plan"></textarea>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="mb-4">

                    <button type="button"
                            id="addMore"
                            class="btn btn-dark rounded-pill px-4">

                        + Add More Project

                    </button>

                </div>

                <div class="text-end">

                    <button type="submit"
                            class="btn btn-primary rounded-pill px-5">

                        Submit EOD

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

$('#addMore').click(function(){

    let html = $('.eod-item:first').clone();

    html.find('textarea').val('');

    html.find('select').val('');

    $('#eodItems').append(html);
});

$(document).on(

    'click',

    '.removeItem',

    function(){

        if($('.eod-item').length > 1){

            $(this)
                .closest('.eod-item')
                .remove();
        }
    }

);

</script>

@endsection