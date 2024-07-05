<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#chatboostsourcepremium
 */
final readonly class ChatBoostSourcePremium implements ChatBoostSource
{
    public function __construct(
        public User $user,
    ) {
    }

    public function getSource(): string
    {
        return 'premium';
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
