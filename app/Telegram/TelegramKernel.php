<?php

declare(strict_types=1);

namespace App\Telegram;

use App\Exceptions\BotException;
use App\Telegram\Actions\LanguageSelectAction;
use App\Telegram\Command\Common\DebugCommand;
use App\Telegram\Command\MainCommand;
use App\Telegram\Command\StartCommand;
use App\Telegram\Helpers\Callback;
use Error;
use ErrorException;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use TypeError;

readonly class TelegramKernel
{
    private Api $bot;

    /**
     * @throws TelegramSDKException
     */
    public function __construct(Api $bot)
    {
        $this->bot = $bot;
        $this->initializeCommands();
    }

    /**
     * @throws TelegramSDKException
     */
    public function run(\Closure $next): mixed
    {
        try {
            $update = $this->bot->getWebhookUpdate();

            if ($this->isCommand($update->getMessage()->get('entities', collect()))) {
                $command = $this->extractCommand($update->getMessage()->get('text'));

                if ($command && array_key_exists($command, $this->bot->getCommands())) {

                    $this->executeCommand($command, true);

                    return $next('Command executed.');
                }
            }

            if ($callbackQuery = $update->callbackQuery) {

                $this->handleCallbackQuery($callbackQuery);

                return $next('Callback query handled.');
            }

            if ($commandMessage = $update->getMessage()->get('text')) {
                if ($command = $this->getCommandByText($commandMessage)) {

                    $this->executeCommand($command);

                    return $next('Command executed by text.');
                }
            }

            throw new BotException('Command error');

        } catch (TelegramSDKException|ErrorException|BotException|TypeError|Error $exception) {
            $this->bot->sendMessage([
                'chat_id' => auth()->user()->telegram_id,
                'text' => $exception->getMessage()
            ]);

            return $next('Server encountered an error.');
        }
    }

    private function isCommand($entities): bool
    {
        return $entities->contains('type', 'bot_command');
    }

    private function extractCommand(string $text): ?string
    {
        preg_match('/^\/(\w+)\b/i', $text, $command);
        return $command[1] ?? null;
    }

    /**
     * @throws TelegramSDKException
     * @throws BotException
     */
    private function handleCallbackQuery($callbackQuery): void
    {
        Callback::setParams($callbackQuery->data);

        $this->bot->answerCallbackQuery([
            'callback_query_id' => $callbackQuery->id
        ]);

        if(Callback::getAction() == null || !array_key_exists(Callback::getAction(), $this->bot->getCommands())) {
            throw new BotException("Button not found.\n\nParams " . Callback::getAction());
        }

        $this->executeCommand(Callback::getAction());
    }

    private function executeCommand(string $command, bool $isCommand = false): void
    {
        auth()->user()->update([
            'command' => $command
        ]);

        if ($isCommand) {
            $this->bot->commandsHandler(true);
        } else {
            $this->bot->triggerCommand($command, $this->bot->commandsHandler(true));
        }
    }

    /**
     * @throws TelegramSDKException
     */
    private function initializeCommands(): void
    {
        $this->bot->addCommands([
            StartCommand::class,
            MainCommand::class,
            DebugCommand::class,
            LanguageSelectAction::class,
        ]);
    }

    private function getCommandByText(string $commandMessage): ?string
    {
        foreach ($this->bot->getCommands() as $command) {
            if (in_array($commandMessage, $command->getAliases())) {
                return $command->getName();
            }
        }
        return null;
    }
}
