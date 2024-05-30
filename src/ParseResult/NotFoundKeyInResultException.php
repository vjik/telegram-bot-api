<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult;

final class NotFoundKeyInResultException extends TelegramParseResultException
{
    public function __construct(string $key)
    {
        parent::__construct('Not found key "' . $key . '" in result object.');
    }
}
