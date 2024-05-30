<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Client\TelegramClientInterface;

final class TelegramBotApi
{
    public function __construct(
        private TelegramClientInterface $telegramClient,
    ) {
    }

    public function send(TelegramRequestInterface $request): mixed
    {
        $response = $this->telegramClient->send($request);

        /**
         * @see https://core.telegram.org/bots/api#making-requests
         */
        if (($response['ok'] ?? false) !== true) {
            throw new TelegramRuntimeException('Request is failed.');
        }
        $result = $response['result'];

        $successCallback = $request->getSuccessCallback();
        if ($successCallback !== null) {
            $result = $successCallback($result);
        }

        return $result;
    }
}
