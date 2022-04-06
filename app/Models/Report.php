<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'title',
        'report_link'
    ];

    protected $casts = [
        'created_at' => 'date:d/m/Y',
    ];
}
