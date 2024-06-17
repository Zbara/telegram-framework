<?php

namespace App\Telegram\Helpers;

use App\Exceptions\BotException;
use Illuminate\Support\Collection;
use Telegram\Bot\Keyboard\Keyboard;

class KeyboardGenerate
{
    private Collection $inline;

    /**
     * Static method to create a KeyboardGenerate instance and generate the keyboard.
     *
     * @param Collection $languages
     * @param string $action
     * @param array $params
     * @param int $rows
     * @return KeyboardGenerate
     */
    public static function make(
        Collection $languages,
        string     $action,
        array      $params = [],
        int        $rows = 25
    ): KeyboardGenerate
    {
        return (new self())->generate($languages, $action, $params, $rows);
    }

    /**
     * Generate the inline keyboard based on the provided languages, action, parameters, and rows.
     *
     * @param Collection $languages
     * @param string $action
     * @param array $params
     * @param int $rows
     * @return self
     * @throws BotException
     */
    public function generate(
        Collection $languages,
        string     $action,
        array      $params = [],
        int        $rows = 25
    ): self
    {
        $this->inline = collect();

        $paramsData = [];

        foreach ($params as $key => $value) {
            if (is_numeric($key)) {
                $paramsData[$value] = null;

                unset($params[$key]);
            };
        }

        // Chunk the languages into specified number of rows
        foreach ($languages->chunk(3) as $chunk) {
            $buttons = collect();

            foreach ($chunk as $value) {
                foreach ($paramsData as $key => $item) {
                    if (isset($value->$key)) {
                        $params[$key] = $value->$key;
                    }
                }

                $buttons->add(
                    Keyboard::inlineButton([
                        'text' => $value->name,
                        'callback_data' => Callback::generateCallbackData($action, $params)
                    ])
                );
            }

            $this->inline->add($buttons);

            unset($buttons);
        }

        return $this;
    }

    /**
     * Render the inline keyboard.
     *
     * @return Keyboard
     */
    public function render(): Keyboard
    {
        return Keyboard::make([
            'inline_keyboard' => $this->inline,
            'resize_keyboard' => true,
        ]);
    }
}
