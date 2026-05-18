<div class="sidebar bg-dark text-white p-3">

    <div class="mb-4">

        <h3 class="fw-bold mb-0">
            ADAMs
        </h3>

        <small class="text-secondary">
            Admin Panel
        </small>

    </div>

    <ul class="nav flex-column">

        <li class="nav-item mb-2">

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <i class="bi bi-speedometer2 me-2"></i>

                Dashboard

            </a>

        </li>
        <li class="nav-item mb-2">

            <a class="nav-link d-flex justify-content-between align-items-center
                {{ request()->routeIs('roles.*') || request()->routeIs('departments.*') ? 'active' : '' }}"
            data-bs-toggle="collapse"
            href="#mastersMenu"
            role="button"
            aria-expanded="true">

                <span>

                    <i class="bi bi-folder me-2"></i>

                    Masters

                </span>

                <i class="bi bi-chevron-down small"></i>

            </a>

            <div class="collapse show
                {{ request()->routeIs('roles.*') || request()->routeIs('departments.*') ? 'show' : '' }}"
                id="mastersMenu">

                <ul class="nav flex-column ms-3 mt-2">

                    <li class="nav-item mb-1">

                        <a href="{{ route('departments.index') }}"
                        class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">

                            <i class="bi bi-diagram-3 me-2"></i>

                            Department

                        </a>

                    </li>

                    <li class="nav-item mb-1">

                        <a href="{{ route('roles.index') }}"
                        class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">

                            <i class="bi bi-shield-lock me-2"></i>

                            Roles

                        </a>

                    </li>

                </ul>

            </div>

        </li>
        <li class="nav-item mb-2">

            <a href="{{ route('users.index') }}"
            class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">

                <i class="bi bi-person-lines-fill me-2"></i>

                Employees

            </a>

        </li>

        <li class="nav-item mb-2">

            <a href="#"
               class="nav-link">

                <i class="bi bi-calendar-check me-2"></i>

                Attendance

            </a>

        </li>

    </ul>

</div>