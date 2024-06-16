<?php

namespace App\Admin\Controllers;

use App\Actions\Admin\Settings\SaveSettingsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SetSettingsRequest;
use App\Http\Resources\Admin\ConfigSystemResource;
use App\Models\System\ConfigSystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

class SettingsController extends Controller
{
    public function getSettings(): JsonResponse
    {
        $result = collect([
            'config' => ConfigSystemResource::collection(
                ConfigSystem::all()
            ),
            'webhook' => route('telegram.bot'),
        ]);

        if (Config::get('telegram.bots.bot.token') !== null) {
            try {
                $bot = new Api(Config::get('telegram.bots.bot.token'));
                $result->put('webhookInfo', $bot->getWebhookInfo());
            } catch (TelegramSDKException $e) {}
        }

        return response()->json($result);
    }

    /**
     * @throws TelegramSDKException
     */
    public function setSettings(
        SetSettingsRequest $request,
        SaveSettingsAction $saveSettings
    ): void
    {
        $saveSettings($request->validated());
    }
}
