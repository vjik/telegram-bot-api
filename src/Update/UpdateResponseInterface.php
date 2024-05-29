<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Update;

use Vjik\TelegramBot\Api\Client\Request\TelegramRequestInterface;

interface UpdateResponseInterface
{
    public function withTelegramRequest(TelegramRequestInterface... $request): static;

    public function withAddedTelegramRequest(TelegramRequestInterface... $request): static;

    /**
     * @return TelegramRequestInterface[]
     */
    public function getTelegramRequests(): array;
}
