<?php

namespace App\Telegram;

use App\Exceptions\AuthUserErrorException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Telegram\Bot\Objects\Chat;
use Telegram\Bot\Objects\Message;

class UserTelegram
{
    /**
     * @param Chat $userData
     * @return User
     * @throws AuthUserErrorException
     */
    public static function authOrRegister(
        Collection $userData,
    ): User
    {
        if ($userData->id !== null) {
            $user = User::query()
                ->with([
                    'language'
                ])
                ->where('telegram_id', $userData->id)
                ->first();

            if (null === $user) {
                $user = User::query()
                    ->create([
                        'telegram_id' => $userData->id,
                        'username' => $userData->username,
                        'first_name' => $userData->firstName,
                        'last_name' => $userData->lastName,
                        'last_activity_at' => Carbon::now(),
                        'command' => 'start',
                    ]);
            }

            User::query()
                ->where('id', $user->id)
                ->update([
                    'username' => $userData->username,
                    'first_name' => $userData->firstName,
                    'last_name' => $userData->lastName,
                    'last_activity_at' => \Illuminate\Support\Carbon::now()
                ]);

            Auth::login($user);

            return $user;
        }

        throw new AuthUserErrorException('User params not found.');
    }
}
