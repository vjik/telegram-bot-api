<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport;

/**
 * @api
 */
final readonly class ApiResponse
{
    public function __construct(
        public int $statusCode,
        public string $body,
    ) {}
}
