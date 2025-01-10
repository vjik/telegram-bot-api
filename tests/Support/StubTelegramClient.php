<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Support;

use Vjik\TelegramBot\Api\Transport\TelegramClientInterface;
use Vjik\TelegramBot\Api\Transport\TelegramResponse;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;

final class StubTelegramClient implements TelegramClientInterface
{
    public function __construct(
        private ?TelegramResponse $response = null,
    ) {}

    public function send(TelegramRequestInterface $request): TelegramResponse
    {
        return $this->response ?? new TelegramResponse(200, '');
    }
}
