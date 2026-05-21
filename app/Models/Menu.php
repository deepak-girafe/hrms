<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [

        'menu_name',
        'route_name',
        'icon',
        'sort_order',
        'status'

    ];

    public function roles()
    {
        return $this->belongsToMany(

            Role::class,
            'role_menu_permissions',
            'menu_id',
            'role_id'

        );
    }
}