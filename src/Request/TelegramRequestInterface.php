<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Request;

interface TelegramRequestInterface
{
    public function getHttpMethod(): HttpMethod;

    /**
     * @see https://core.telegram.org/bots/api#available-methods     *
     */
    public function getApiMethod(): string;

    /**
     * Request data to be passed as a request body via POST
     */
    public function getData(): array;

    public function getSuccessCallback(): ?callable;
}
