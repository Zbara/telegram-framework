<?php

namespace App\Models\System;

use App\Models\Language\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    public function language(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Language::class, 'value', 'id');
    }
}
