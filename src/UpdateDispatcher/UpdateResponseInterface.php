<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\UpdateDispatcher;

use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;

interface UpdateResponseInterface
{
    public function withTelegramRequest(TelegramRequestInterface... $request): static;

    public function withAddedTelegramRequest(TelegramRequestInterface... $request): static;

    /**
     * @return TelegramRequestInterface[]
     */
    public function getTelegramRequests(): array;
}
