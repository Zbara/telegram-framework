<?php

namespace App\Telegram\Helpers;

use App\Exceptions\BotException;

/**
 * Class Callback
 *
 * @package App\Telegram\Helpers
 *
 * @param string $params
 * @throws BotException
 */
class Callback
{
    private static array $params = [];

    /**
     * @param string $params
     * @return void
     */
    public static function setParams(
        string $params
    ): void
    {
        $data = explode(';', $params);

        if (is_array($data) && count($data)) {
           self::$params = $data;
        }
    }

    /**
     * @return array|mixed|string|null
     * @throws BotException
     */
    public static function getAction(): mixed
    {
        return self::getParams('action');
    }

    /**
     * @param string|null $search
     * @return array|mixed|string|null
     * @throws BotException
     */
    public static function getParams(
        string $search = null
    ): mixed
    {
        $result = [];

        foreach (self::$params as $item) {
            list($key, $value) = explode('=', $item);

            $result[$key] = $value;
        }

        if(count($result)) {
            if($search === null) {
                return $result;
            }

            if(!array_key_exists($search, $result)) {
                throw new BotException(sprintf('Params %s not found', $search));
            }

            return $result[$search];
        }
        throw new BotException('Params not found');
    }

    /**
     * @param string $action
     * @param array $params
     * @return string
     * @throws BotException
     */
    public static function generateCallbackData(
        string $action,
        array $params
    ): string
    {
        $req_array = '';

        foreach ($params as $key => $value) {
            $req_array .= ';' . $key . '=' . $value;
        }

        $data = 'action=' . $action . $req_array;

        if(strlen($data) <= 64) {
            return $data;
        }

        throw new BotException('Callback data is too long');
    }
}
