<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use Vjik\TelegramBot\Api\Client\TelegramResponse;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Type\ResponseParameters;

final readonly class FailResult
{
    public function __construct(
        public TelegramRequestInterface $request,
        public TelegramResponse $response,
        public ?string $description = null,
        public ?ResponseParameters $parameters = null,
        public mixed $errorCode = null,
    ) {}
}
