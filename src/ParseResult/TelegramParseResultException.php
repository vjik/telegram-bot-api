<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult;

use Throwable;
use Vjik\TelegramBot\Api\TelegramRuntimeException;

class TelegramParseResultException extends TelegramRuntimeException
{
    public function __construct(
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null,
        public string|array|null $raw = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
