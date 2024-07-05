<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#chatboostsourcegiftcode
 */
final readonly class ChatBoostSourceGiftCode implements ChatBoostSource
{
    public function __construct(
        public User $user,
    ) {
    }

    public function getSource(): string
    {
        return 'gift_code';
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
