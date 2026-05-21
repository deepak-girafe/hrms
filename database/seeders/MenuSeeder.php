<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [

            [
                'menu_name' => 'Dashboard',
                'route_name' => 'dashboard',
                'icon' => 'bi-speedometer2',
                'sort_order' => 1
            ],

            [
                'menu_name' => 'Users',
                'route_name' => 'users.index',
                'icon' => 'bi-people',
                'sort_order' => 2
            ],

            [
                'menu_name' => 'Roles',
                'route_name' => 'roles.index',
                'icon' => 'bi-shield-lock',
                'sort_order' => 3
            ],

            [
                'menu_name' => 'Departments',
                'route_name' => 'departments.index',
                'icon' => 'bi-diagram-3',
                'sort_order' => 4
            ],

            [
                'menu_name' => 'Projects',
                'route_name' => 'projects.index',
                'icon' => 'bi-kanban',
                'sort_order' => 5
            ],

            [
                'menu_name' => 'Leave Types',
                'route_name' => 'leave-types.index',
                'icon' => 'bi-tags',
                'sort_order' => 6
            ],

            [
                'menu_name' => 'Leave Policies',
                'route_name' => 'leave-policies.index',
                'icon' => 'bi-sliders',
                'sort_order' => 7
            ],

            [
                'menu_name' => 'Holidays',
                'route_name' => 'holidays.index',
                'icon' => 'bi-calendar-event',
                'sort_order' => 8
            ],
            [
                'menu_name' => 'Attendance',
                'route_name' => 'attendance.index',
                'icon' => 'bi-clock-history',
                'sort_order' => 10
            ]

        ];

        foreach ($menus as $menu) {

            Menu::updateOrCreate(

                [
                    'route_name' => $menu['route_name']
                ],

                $menu

            );
        }
    }
}