<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentMaster extends Model
{
    protected $fillable = [

        'document_name',

        'description',

        'is_required',

        'status'

    ];
}