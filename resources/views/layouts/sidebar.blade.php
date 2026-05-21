@php

use App\Models\Menu;

$user = auth()->user()->load('role.menus');

if($user->role_id == 5) {

$userMenus = [

    'dashboard',
    'users.index',
    'roles.index',
    'departments.index',
    'projects.index',
    'leave-types.index',
    'leave-policies.index',
    'holidays.index',
    'role-permissions.index'

];

} else {

$userMenus = $user->role
    ? $user->role->menus
        ->pluck('route_name')
        ->toArray()
    : [];
}

@endphp

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

        {{-- Dashboard --}}

        @if(in_array('dashboard', $userMenus))

            <li class="nav-item mb-2">

                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                    <i class="bi bi-speedometer2 me-2"></i>

                    Dashboard

                </a>

            </li>

        @endif

        {{-- Masters Menu --}}

        @if(
            in_array('departments.index', $userMenus) ||
            in_array('roles.index', $userMenus) ||
            in_array('holidays.index', $userMenus) ||
            in_array('role-permissions.index', $userMenus)
        )

            <li class="nav-item mb-2">

                <a class="nav-link d-flex justify-content-between align-items-center
                    {{ request()->routeIs('roles.*')
                        || request()->routeIs('departments.*')
                        || request()->routeIs('holidays.*')
                        || request()->routeIs('role-permissions.*')
                            ? 'active'
                            : '' }}"
                   data-bs-toggle="collapse"
                   href="#mastersMenu"
                   role="button">

                    <span>

                        <i class="bi bi-folder me-2"></i>

                        Masters

                    </span>

                    <i class="bi bi-chevron-down small"></i>

                </a>

                <div class="collapse
                    {{ request()->routeIs('roles.*')
                        || request()->routeIs('departments.*')
                        || request()->routeIs('holidays.*')
                        || request()->routeIs('role-permissions.*')
                            ? 'show'
                            : '' }}"
                     id="mastersMenu">

                    <ul class="nav flex-column ms-3 mt-2">

                        @if(in_array('departments.index', $userMenus))

                            <li class="nav-item mb-1">

                                <a href="{{ route('departments.index') }}"
                                   class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">

                                    <i class="bi bi-diagram-3 me-2"></i>

                                    Department

                                </a>

                            </li>

                        @endif

                        @if(in_array('roles.index', $userMenus))

                            <li class="nav-item mb-1">

                                <a href="{{ route('roles.index') }}"
                                   class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">

                                    <i class="bi bi-shield-lock me-2"></i>

                                    Roles

                                </a>

                            </li>

                        @endif

                        @if(in_array('holidays.index', $userMenus))

                            <li class="nav-item mb-1">

                                <a href="{{ route('holidays.index') }}"
                                   class="nav-link {{ request()->routeIs('holidays.*') ? 'active' : '' }}">

                                    <i class="bi bi-calendar-event me-2"></i>

                                    Holidays

                                </a>

                            </li>

                        @endif

                        @if(in_array('role-permissions.index', $userMenus))

                            <li class="nav-item mb-1">

                                <a href="{{ route('role-permissions.index') }}"
                                   class="nav-link {{ request()->routeIs('role-permissions.*') ? 'active' : '' }}">

                                    <i class="bi bi-key me-2"></i>

                                    Permissions

                                </a>

                            </li>

                        @endif

                    </ul>

                </div>

            </li>

        @endif

        {{-- Leave Management --}}

        @if(
            in_array('leave-types.index', $userMenus) ||
            in_array('leave-policies.index', $userMenus)
        )

            <li class="nav-item mb-2">

                <a class="nav-link d-flex justify-content-between align-items-center
                    {{ request()->routeIs('leave-types.*')
                        || request()->routeIs('leave-policies.*')
                            ? 'active'
                            : '' }}"
                   data-bs-toggle="collapse"
                   href="#leaveMenu"
                   role="button">

                    <span>

                        <i class="bi bi-calendar2-check me-2"></i>

                        Leave Management

                    </span>

                    <i class="bi bi-chevron-down small"></i>

                </a>

                <div class="collapse
                    {{ request()->routeIs('leave-types.*')
                        || request()->routeIs('leave-policies.*')
                            ? 'show'
                            : '' }}"
                     id="leaveMenu">

                    <ul class="nav flex-column ms-3 mt-2">

                        @if(in_array('leave-types.index', $userMenus))

                            <li class="nav-item mb-1">

                                <a href="{{ route('leave-types.index') }}"
                                   class="nav-link {{ request()->routeIs('leave-types.*') ? 'active' : '' }}">

                                    <i class="bi bi-tags me-2"></i>

                                    Leave Types

                                </a>

                            </li>

                        @endif

                        @if(in_array('leave-policies.index', $userMenus))

                            <li class="nav-item mb-1">

                                <a href="{{ route('leave-policies.index') }}"
                                   class="nav-link {{ request()->routeIs('leave-policies.*') ? 'active' : '' }}">

                                    <i class="bi bi-sliders me-2"></i>

                                    Leave Policies

                                </a>

                            </li>

                        @endif

                    </ul>

                </div>

            </li>

        @endif

        {{-- Projects --}}

        @if(in_array('projects.index', $userMenus))

            <li class="nav-item mb-2">

                <a href="{{ route('projects.index') }}"
                   class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}">

                    <i class="bi bi-kanban me-2"></i>

                    Projects

                </a>

            </li>

        @endif

        {{-- Employees --}}

        @if(in_array('users.index', $userMenus))

            <li class="nav-item mb-2">

                <a href="{{ route('users.index') }}"
                   class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">

                    <i class="bi bi-person-lines-fill me-2"></i>

                    Employees

                </a>

            </li>

        @endif

        @if(
                in_array('attendance.index', $userMenus)
                || strtolower(auth()->user()->role->name ?? '') != 'admin'
            )

            <li class="nav-item mb-2">

                <a href="{{ route('attendance.index') }}"
                class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">

                    <i class="bi bi-clock-history me-2"></i>

                    Attendance

                </a>

            </li>

            @endif

            <li class="nav-item mb-2">

            <a href="{{ route('payrolls.index') }}"
            class="nav-link {{ request()->routeIs('payrolls.*') ? 'active' : '' }}">

                <i class="bi bi-cash-stack me-2"></i>

                Payroll

            </a>

            </li>    

    </ul>

</div>