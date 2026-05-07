<nav class="navbar navbar-expand-lg bg-white shadow-sm px-4 py-3">

    <div class="container-fluid">

        <h5 class="mb-0 fw-bold">

            @yield('title', 'Dashboard')

        </h5>

        <div class="d-flex align-items-center">

            <div class="dropdown">

                <button class="btn btn-light border dropdown-toggle"
                        data-bs-toggle="dropdown">

                    <i class="bi bi-person-circle me-1"></i>

                    {{ Auth::user()->name }}

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>

                        <a class="dropdown-item"
                           href="#">

                            Profile

                        </a>

                    </li>

                    <li>

                        <hr class="dropdown-divider">

                    </li>

                    <li>

                        <form method="POST"
                              action="{{ route('logout') }}">

                            @csrf

                            <button class="dropdown-item text-danger">

                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>