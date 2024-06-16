<?php

namespace App\Services;

use App\Models\Language\Language;
use App\Models\Language\TranslationText;
use App\Models\System\ConfigSystem;
use App\Models\User;

class LanguageService
{
    private static ?LanguageService $instance = null;
    private array $language = [];
    private static int $lang;

    private function __construct()
    {
        $language = TranslationText::select(['translation_texts.translation', 'translations.key'])
            ->join('languages', 'languages.id', '=', 'translation_texts.locale_id')
            ->join('translations', 'translations.id', '=', 'translation_texts.translatable_id')
            ->where('languages.code',  app()->getLocale())
            ->get();

        $this->language = $language->pluck('translation', 'key')->toArray();
    }

    public static function setLang(): void
    {
        $language = Language::query()
            ->where('code', app()->getLocale())
            ->first();

        if ($language !== null) {
            self::$lang = $language->id;
        }

        self::$lang = 1;
    }

    public static function getLang(): int
    {
        return self::$lang;
    }

    public static function clearInstance(): void
    {
        self::$instance = null;
    }

    public static function getInstance(): LanguageService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getText(
        string $key,
        array $replace = null
    ): string
    {
        $translation = $this->language[trim($key)] ?? $key;

        if (is_array($replace)) {
            foreach ($replace as $placeholder => $value) {
                $translation = str_replace(":" . $placeholder, $value, $translation);
            }
        }

        // Add support for {if} conditionals
        $translation = preg_replace_callback(
            '/\{if\s+(.*?)\s*!==\s*(".*?"|\'.*?\')\}([\s\S]*?)\{\/endif\}/s',
            function ($matches) use ($replace) {
                $conditionVariable = $matches[1];
                $conditionValue = trim($matches[2], '\'"');
                $content = $matches[3];
                if (isset($replace[$conditionVariable]) && $replace[$conditionVariable] !== $conditionValue) {
                    // Trim indentation and remove extra newlines
                    $content = preg_replace('/^\s*/m', '', $content);
                    $content = preg_replace('/\n+/', ' ', $content);
                    return $content;
                } else {
                    return '';
                }
            },
            $translation
        );

        return $translation;
    }

    public static function setLocale(
        User $user
    ): void
    {
        $language = Language::query()
            ->where('active', 1)
            ->count();

        if($user->language_id !== null and $language > 1){
            app()->setLocale($user->language?->code ?? 'ru');
        }

        if($language === 1){
            $lang = ConfigSystem::query()
                ->with('language')
                ->where('key', '=', 'lang')
                ->first();

            if(isset($lang->id) and $lang->language !== null){
                app()->setLocale($lang->language->value);
            }
        }
    }
}
