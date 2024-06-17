<?php

namespace App\Http\Controllers;


use App\Telegram\TelegramKernel;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Entry point for messages from telegram
 *
 * Class TelegramController
 *
 * @package App\Http\Controllers
 */
class TelegramController extends Controller
{
    /**
     * Process telegram webhook
     *
     * @throws TelegramSDKException
     */
    public function __invoke(
        TelegramKernel $telegramKernel
    )
    {
        return response([
            'ok' => true,
            'message' => $telegramKernel->run(
                fn ($next) => $next
            )
        ], 200);
    }
}
