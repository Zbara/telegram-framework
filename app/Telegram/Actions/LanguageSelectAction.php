<?php

namespace App\Telegram\Actions;

use App\Exceptions\BotException;
use App\Models\Language\Language;
use App\Services\LanguageService;
use App\Telegram\Helpers\Callback;
use Illuminate\Support\Facades\App;
use Telegram\Bot\Commands\Command;

class LanguageSelectAction extends Command
{
    protected string $name = 'language-select';

    /**
     * @throws BotException
     */
    public function handle(): void
    {
        $lang = Language::query()
            ->where('id', Callback::getParams('id'))
            ->first();

        if (empty($lang)) {
            throw new BotException('Language not found');
        }

        LanguageService::clearInstance();

        auth()->user()->update([
            'language_id' => $lang->id
        ]);

        App::setLocale($lang->code);

        $this->triggerCommand('main');
    }
}
