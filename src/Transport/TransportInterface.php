<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport;

interface TransportInterface
{
    public function send(TelegramRequestInterface $request): TelegramResponse;
}
