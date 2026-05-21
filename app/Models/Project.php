<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [

        'project_name',
        'project_code',
        'start_date',
        'end_date',
        'project_cost',
        'priority',
        'status',
        'description'

    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}