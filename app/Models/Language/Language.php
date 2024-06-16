<?php

namespace App\Models\Language;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'sort',
        'active',
    ];

    public function scopeActive(
        Builder $builder
    ): void
    {
        $builder->where('active', 1);
    }
}
