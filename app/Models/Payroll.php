<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [

        'user_id',
        'salary_month',
        'working_days',
        'present_days',
        'leave_days',
        'absent_days',
        'gross_salary',
        'total_deduction',
        'net_salary',
        'salary_date',
        'payment_status'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}