<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult;

use Throwable;
use Vjik\TelegramBot\Api\TelegramRuntimeException;

class TelegramParseResultException extends TelegramRuntimeException
{
    public function __construct(
        string $message,
        public mixed $raw,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, previous: $previous);
    }
}
