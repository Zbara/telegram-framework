<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'key' => 'ru',
                'value' => 'Русский'
            ],
            [
                'key' => 'en',
                'value' => 'English'
            ],
            [
                'key' => 'uk',
                'value' => 'Українська'
            ],
            [
                'key' => 'de',
                'value' => 'Deutsch'
            ],
            [
                'key' => 'fr',
                'value' => 'Français'
            ],
            [
                'key' => 'es',
                'value' => 'Español'
            ],
            [
                'key' => 'it',
                'value' => 'Italiano'
            ],
            [
                'key' => 'pl',
                'value' => 'Polski'
            ],
            [
                'key' => 'ja',
                'value' => '日本語'
            ],
            [
                'key' => 'ko',
                'value' => '한국어'
            ],
        ];

        foreach ($languages as $key => $language) {
            \App\Models\Language\Language::create([
                'name' => $language['value'],
                'code' => $language['key'],
                'sort' => $key + 1
            ]);
        }
    }
}
