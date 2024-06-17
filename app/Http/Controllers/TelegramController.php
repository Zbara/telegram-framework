<?php

namespace App\Http\Controllers;


use App\Telegram\TelegramKernel;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramController extends Controller
{
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
