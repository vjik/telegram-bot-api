<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Client\Request;

interface TelegramRequestInterface
{
    /**
     * Telegram API request method
     *
     * @see https://core.telegram.org/bots/api#available-methods     *
     */
    public function getMethod(): string;

    /**
     * Request data to be passed as a request body via POST
     */
    public function getData(): array;

}
