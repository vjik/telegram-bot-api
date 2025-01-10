<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Support;

use Vjik\TelegramBot\Api\Transport\TransportInterface;
use Vjik\TelegramBot\Api\Transport\TelegramResponse;
use Vjik\TelegramBot\Api\Transport\TelegramRequestInterface;

final class StubTransport implements TransportInterface
{
    public function __construct(
        private ?TelegramResponse $response = null,
    ) {}

    public function send(TelegramRequestInterface $request): TelegramResponse
    {
        return $this->response ?? new TelegramResponse(200, '');
    }
}
