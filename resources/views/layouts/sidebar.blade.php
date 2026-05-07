<div class="sidebar bg-dark text-white p-3">

    <div class="mb-4">

        <h3 class="fw-bold mb-0">
            HRMS
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

            <a href="{{ route('employees.index') }}"
               class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">

                <i class="bi bi-people me-2"></i>

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