<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use Vjik\TelegramBot\Api\Transport\ApiResponse;
use Vjik\TelegramBot\Api\Type\ResponseParameters;

final readonly class FailResult
{
    public function __construct(
        public MethodInterface $method,
        public ApiResponse $response,
        public ?string $description = null,
        public ?ResponseParameters $parameters = null,
        public mixed $errorCode = null,
    ) {}
}
