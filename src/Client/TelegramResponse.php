<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Client;

final readonly class TelegramResponse
{
    public function __construct(
        public int $statusCode,
        public string $body,
    ) {
    }
}
