<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyEodItem extends Model
{
    protected $fillable = [

        'daily_eod_id',

        'project_id',

        'work_done',

        'blockers',

        'tomorrow_plan'

    ];

    /*
    |--------------------------------------------------------------------------
    | Parent EOD
    |--------------------------------------------------------------------------
    */

    public function eod()
    {
        return $this->belongsTo(

            DailyEod::class,

            'daily_eod_id',

            'id'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Project
    |--------------------------------------------------------------------------
    */

    public function project()
    {
        return $this->belongsTo(

            Project::class,

            'project_id',

            'id'

        );
    }
}