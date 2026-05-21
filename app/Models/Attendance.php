<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [

        'user_id',
        'attendance_date',
        'punch_in',
        'punch_out',
        'punch_in_image',
        'punch_out_image',
        'working_hours',
        'status',
        'punch_in_latitude',
        'punch_in_longitude',
        'punch_out_latitude',
        'punch_out_longitude',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}