<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConfigSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $config = [
            [
                'key' => 'app_name',
                'value' => 'Avto-Bot',
            ],
            [
                'key' => 'bot_token',
                'value' => 'test'
            ],
            [
                'key' => 'bot_username',
                'value' => 'test'
            ],
            [
                'key' => 'language',
                'value' => 1
            ]
        ];

        \App\Models\System\ConfigSystem::insert($config);
    }
}
