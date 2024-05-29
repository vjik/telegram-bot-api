<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Client;

use Vjik\TelegramBot\Api\Client\Request\TelegramRequestInterface;

interface TelegramClientInterface
{
    public function send(TelegramRequestInterface $request): ?array;
}
