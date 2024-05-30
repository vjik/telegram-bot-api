<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#chatboostsource
 */
interface ChatBoostSource
{
    public function getSource(): string;

    public function getUser(): ?User;
}
