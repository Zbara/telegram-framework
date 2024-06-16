<?php

namespace App\Models\Language;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslationText extends Model
{
    use HasFactory;

    protected $fillable = [
        'translatable_id',
        'locale_id',
        'translation'
    ];

    public $timestamps = false;
}
