<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Request;

interface TelegramRequestInterface
{
    public function getHttpMethod(): HttpMethod;

    /**
     * @see https://core.telegram.org/bots/api#available-methods
     */
    public function getApiMethod(): string;

    /**
     * @psalm-return array<string, mixed>
     */
    public function getData(): array;
}
