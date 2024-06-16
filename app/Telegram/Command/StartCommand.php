<?php

namespace App\Telegram\Command;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Start command';

    public function handle(): void
    {
        // Отправляем ответ с уровнем отладки
        $this->replyWithMessage(['text' => "Debug level"]);
    }
}
