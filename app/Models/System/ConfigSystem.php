<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];
}
