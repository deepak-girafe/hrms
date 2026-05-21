<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white">

        <h5 class="fw-bold mb-0">

            Manage Permissions :
            {{ $role->name }}

        </h5>

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('role-permissions.update', $role->id) }}">

            @csrf

            <div class="row">

                @foreach($menus as $menu)

                    <div class="col-md-4 mb-3">

                        <div class="card border rounded-3">

                            <div class="card-body">

                                <div class="form-check">

                                    <input type="checkbox"
                                           class="form-check-input"
                                           name="menus[]"
                                           value="{{ $menu->id }}"

                                        {{ $role->menus
                                                ->pluck('id')
                                                ->contains($menu->id)
                                                    ? 'checked'
                                                    : '' }}>

                                    <label class="form-check-label fw-semibold">

                                        <i class="bi {{ $menu->icon }} me-2"></i>

                                        {{ $menu->menu_name }}

                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

            <button type="submit"
                    class="btn btn-primary rounded-pill px-4">

                Save Permissions

            </button>

        </form>

    </div>

</div>