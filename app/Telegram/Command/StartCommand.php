<?php

namespace App\Telegram\Command;

use App\Models\Language\Language;
use App\Telegram\Helpers\KeyboardGenerate;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Start command';

    public function handle(): void
    {
        $this->replyWithMessage([
            'text' => translate('start-text', [
                'first_name' => auth()->user()->first_name,
            ]),
            'reply_markup' => KeyboardGenerate::make(
                Language::query()->active()->get(), 'language-select', ['id'], 3
            )->render(),
        ]);
    }
}
