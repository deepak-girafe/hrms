<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeavePolicy extends Model
{
    protected $fillable = [

        'role_id',
        'leave_type_id',
        'employment_type',
        'allowed_leaves',
        'leave_cycle',
        'carry_forward',
        'max_carry_forward',
        'sandwich_policy',
        'status'

    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
}