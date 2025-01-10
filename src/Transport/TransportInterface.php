<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport;

use Vjik\TelegramBot\Api\Transport\TelegramRequestInterface;

interface TransportInterface
{
    public function send(TelegramRequestInterface $request): TelegramResponse;
}