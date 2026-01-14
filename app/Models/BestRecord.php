<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BestRecord extends Model
{
    protected $fillable = [
        'user_id',
        'recorded_on',
        'category',
        'title',
        'note',
    ];
}
