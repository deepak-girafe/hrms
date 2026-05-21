<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DailyEodItem;

class DailyEod extends Model
{
    protected $fillable = [

        'user_id',

        'eod_date',

        'status'

    ];

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | EOD Items
    |--------------------------------------------------------------------------
    */

    public function items()
    {
        return $this->hasMany(

            DailyEodItem::class,

            'daily_eod_id',

            'id'

        );
    }
}