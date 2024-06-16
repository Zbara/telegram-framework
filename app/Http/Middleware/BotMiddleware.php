<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthUserErrorException;
use App\Models\Language\Language;
use App\Models\System\ConfigSystem;
use App\Services\LanguageService;
use App\Telegram\UserTelegram;
use Closure;
use Illuminate\Http\Request;
use Telegram\Bot\Objects\Update as UpdateObject;

class BotMiddleware
{
    /**
     * @throws AuthUserErrorException
     */
    public function handle(Request $request, Closure $next)
    {
        $update = new UpdateObject($request->all());

        if($update->getChat() !== null && $update->getChat()->count()) {
            $user = UserTelegram::authOrRegister($update->getChat());

            /**
             * Set locale
             *
             * @var Language $language
             */
            LanguageService::setLocale($user);

            return $next($request);
        }

        throw new AuthUserErrorException('Query not found');
    }
}
