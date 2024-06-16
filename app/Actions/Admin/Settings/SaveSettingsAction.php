<?php

namespace App\Actions\Admin\Settings;

use App\Models\System\ConfigSystem;
use Illuminate\Support\Facades\Config;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class SaveSettingsAction
{
    /**
     * @throws TelegramSDKException
     */
    public function __invoke(
        array $settings
    ): void
    {
        foreach ($settings as $key => $value) {
            ConfigSystem::query()
                ->where('key', $key)
                ->update([
                    'value' => $value
                ]);

            if($key === 'bot_token' && Config::get('telegram.bots.bot.token') !== $value) {
                $api = new Api($value);
                $api->setWebhook([
                    'url' => route('telegram.bot'),
                ]);
            }
        }
    }
}
