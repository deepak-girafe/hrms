<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryStructure extends Model
{
    protected $fillable = [

        'user_id',
        'basic_salary',
        'hra',
        'da',
        'ta',
        'medical_allowance',
        'bonus',
        'special_allowance',
        'pf_deduction',
        'esi_deduction',
        'tds_deduction',
        'loan_deduction',
        'other_deduction',
        'gross_salary',
        'net_salary'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}