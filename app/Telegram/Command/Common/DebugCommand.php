<?php

namespace App\Telegram\Command\Common;

use Telegram\Bot\Commands\Command;

class DebugCommand extends Command
{
    protected string $name = 'debug';
    protected string $description = 'Debug command';


    public function handle(): void
    {
        $this->replyWithMessage(['text' => 'Hello ']);
    }
}
