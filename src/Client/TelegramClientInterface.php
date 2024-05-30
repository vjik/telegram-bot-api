<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Client;

use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;

interface TelegramClientInterface
{
    public function send(TelegramRequestInterface $request): TelegramResponse;
}
