<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
      rel="stylesheet" />

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white">

        <h5 class="fw-bold mb-0">

            {{ isset($project)
                ? 'Edit Project'
                : 'Add Project' }}

        </h5>

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ isset($project)
                    ? route('projects.update', $project->id)
                    : route('projects.store') }}">

            @csrf

            @if(isset($project))
                @method('PUT')
            @endif

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Project Name

                    </label>

                    <input type="text"
                           name="project_name"
                           value="{{ old('project_name', $project->project_name ?? '') }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Project Code

                    </label>

                    <input type="text"
                           name="project_code"
                           value="{{ old('project_code', $project->project_code ?? '') }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Start Date

                    </label>

                    <input type="date"
                           name="start_date"
                           value="{{ old('start_date', $project->start_date ?? '') }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        End Date

                    </label>

                    <input type="date"
                           name="end_date"
                           value="{{ old('end_date', $project->end_date ?? '') }}"
                           class="form-control">

                </div>
<!-- 
                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Project Cost

                    </label>

                    <input type="number"
                           step="0.01"
                           name="project_cost"
                           value="{{ old('project_cost', $project->project_cost ?? '') }}"
                           class="form-control">

                </div> -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Priority

                    </label>

                    <select name="priority"
                            class="form-select">

                        <option value="Low">

                            Low

                        </option>

                        <option value="Medium">

                            Medium

                        </option>

                        <option value="High">

                            High

                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Status

                    </label>

                    <select name="status"
                            class="form-select">

                        <option value="Pending">

                            Pending

                        </option>

                        <option value="In Progress">

                            In Progress

                        </option>

                        <option value="Completed">

                            Completed

                        </option>

                        <option value="Hold">

                            Hold

                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Team Members

                    </label>

                    <select name="team_members[]"
                            class="form-select select2"
                            multiple>

                        @foreach($users as $user)

                            <option value="{{ $user->id }}"

                                @if(isset($project) &&
                                    $project->users
                                        ->pluck('id')
                                        ->contains($user->id))
                                    selected
                                @endif>

                                {{ $user->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-12 mb-4">

                    <label class="form-label">

                        Description

                    </label>

                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ old('description', $project->description ?? '') }}</textarea>

                </div>

            </div>

            <button type="submit"
                    class="btn btn-primary rounded-pill px-4">

                Save Project

            </button>

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

</script>