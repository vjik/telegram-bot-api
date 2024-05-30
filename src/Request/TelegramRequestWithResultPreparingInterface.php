<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Request;

interface TelegramRequestWithResultPreparingInterface extends TelegramRequestInterface
{
    public function prepareResult(mixed $result): mixed;
}
