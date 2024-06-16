<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Language\CreatedLangTextRequest;
use App\Http\Requests\Language\EditLangTextOneRequest;
use App\Http\Requests\Language\EditLangTextRequest;
use App\Http\Requests\Language\SetStatusRequest;
use App\Http\Resources\Admin\LanguageResource;
use App\Models\Language\Language;
use App\Models\Language\Translation;
use App\Models\Language\TranslationText;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

/**
 * Class ServicesController
 *
 * @package App\Admin\Controllers
 */
class LanguageController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function getLanguages(): AnonymousResourceCollection
    {
        return LanguageResource::collection(Language::all());
    }

    public function setStatus(
        SetStatusRequest $request
    ): void
    {
        Language::query()
            ->where('id', $request->input('id'))
            ->update([
                'active' => $request->input('status')
            ]);
    }

    public function getLanguageText(): array
    {
        $keys = TranslationText::select(['translation_texts.translation', 'translations.key', 'translations.id', 'languages.code'])
            ->join('languages', 'languages.id', '=', 'translation_texts.locale_id')
            ->join('translations', 'translations.id', '=', 'translation_texts.translatable_id')
            ->where('languages.active',  1)
            ->orderBy('translations.id', 'desc')
            ->get();

        return [
            'language' => Language::query()
                ->active()
                ->get(),
            'text' => $keys,
            'keys' => $keys->pluck('key')->unique()
        ];
    }


    public function createdLangText(
        CreatedLangTextRequest $request
    ): void
    {
        $createdId = Translation::create([
            'key' => Str::slug($request->get('key'))
        ]);

        foreach (Language::active()->get() as $item){
            TranslationText::create([
                'translation' => $request->input(sprintf('text.%s', $item->code)),
                'locale_id' => $item->id,
                'translatable_id' => $createdId->id
            ]);
        }
    }


    public function editLangText(
        EditLangTextRequest $request
    ): void
    {
        $editId = Translation::query()
            ->where('key', $request->get('key'))
            ->first();

        foreach (Language::active()->get() as $item){
            TranslationText::updateOrCreate([
                'locale_id' => $item->id,
                'translatable_id' => $editId->id
            ], [
                'translation' => $request->input(sprintf('text.%s', $item->code)),
            ]);
        }
    }

    public function editLangOne(
        EditLangTextOneRequest $request
    ): void
    {
        $editId = Translation::query()
            ->where('key', $request->input('key'))
            ->first();

        if($lang = Language::query()
            ->where('code', $request->input('lang'))
            ->first()
        ) {
            TranslationText::updateOrCreate([
                'locale_id' => $lang->id,
                'translatable_id' => $editId->id
            ], [
                'translation' => $request->input('text'),
            ]);
        }
    }
}
