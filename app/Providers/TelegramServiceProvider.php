<?php

namespace App\Providers;

use App\Exceptions\ConfigTelegramException;
use App\Models\System\ConfigSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TelegramServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    /**
     * @throws \Exception
     */
    public function boot(
        Request $request
    ): void
    {
        $config = ConfigSystem::query()
            ->whereIn('key', ['bot_token', 'bot_username'])
            ->get();

        foreach ($config as $item) {
            if ($item->key === 'bot_token') {
                config(['telegram.bots.bot.token' => $item->value]);
            } elseif ($item->key === 'bot_username') {
                config(['telegram.bots.bot.username' => $item->value]);
            }
        }

        if(Config::get('telegram.bots.bot.token') === null) {
            throw new ConfigTelegramException('Config telegram.bots.bot.token not found');
        }
    }
}
