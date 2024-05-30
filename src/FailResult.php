<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use Vjik\TelegramBot\Api\Client\TelegramResponse;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Type\ResponseParameters;

final readonly class FailResult
{
    public function __construct(
        public ?string $description,
        public mixed $error_code,
        public ?ResponseParameters $parameters,
        public TelegramRequestInterface $request,
        public TelegramResponse $response,
    ) {
    }
}
