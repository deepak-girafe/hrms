<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    protected $fillable = [

        'user_id',

        'document_master_id',

        'document_file'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documentMaster()
    {
        return $this->belongsTo(

            DocumentMaster::class

        );
    }
}