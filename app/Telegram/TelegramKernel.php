<?php
declare(strict_types=1);

namespace App\Telegram;

use App\Telegram\Command\Common\DebugCommand;
use App\Telegram\Command\StartCommand;
use ErrorException;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

readonly class TelegramKernel
{
    public function __construct(
        private Api $bot
    ){}

    public function run(
        \Closure $next
    )
    {
        try {
            $this->commandList();

            if ($this->bot->getWebhookUpdate()->hasCommand()) {
                preg_match('/^\/(\w+)\b/i', $this->bot->getWebhookUpdate()->getMessage()->get('text'), $command);

                if (array_key_exists($command[1], $this->bot->getCommands())) {
                    auth()->user()->update([
                        'command' => $command[1]
                    ]);

                    $this->bot->commandsHandler(true);
                }
            }

        } catch (TelegramSDKException|ErrorException $exception) {
            logger($exception->getMessage());

            return $next('Server is error.');
        }

        return $next('Server is working.');
    }

    /**
     * @throws TelegramSDKException
     */
    private function commandList(): void
    {
        $this->bot->addCommands([
            StartCommand::class,
            DebugCommand::class,
        ]);
    }
}
