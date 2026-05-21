<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    protected $fillable = [

        'user_id',

        'leave_type_id',

        'from_date',

        'to_date',

        'total_days',

        'reason',

        'status',

        'approved_by',

        'approved_at',

        'is_paid',

        'remarks'

    ];

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Leave Type
    |--------------------------------------------------------------------------
    */

    public function leaveType()
    {
        return $this->belongsTo(
            LeaveType::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Approver
    |--------------------------------------------------------------------------
    */

    public function approver()
    {
        return $this->belongsTo(

            User::class,

            'approved_by'

        );
    }
}