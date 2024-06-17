<?php

namespace App\Telegram\Command;

use App\Models\Language\Language;
use App\Telegram\Helpers\KeyboardGenerate;
use Telegram\Bot\Commands\Command;

class MainCommand extends Command
{
    protected string $name = 'main';
    protected string $description = 'Main command';

    public function handle(): void
    {
        $this->replyWithMessage([
            'text' => translate('start-welcome'),
        ]);
    }
}
