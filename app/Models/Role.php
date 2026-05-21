<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [

        'name',
        'description',
        'reporting_required',
        'status'

    ];
    public function menus()
    {
        return $this->belongsToMany(

            Menu::class,
            'role_menu_permissions'

        );
    }
}