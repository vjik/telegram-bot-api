<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#chatboostsourcegiveaway
 */
final readonly class ChatBoostSourceGiveaway implements ChatBoostSource
{
    public function __construct(
        public int $giveawayMessageId,
        public ?User $user,
        public ?true $isUnclaimed,
    ) {
    }

    public function getSource(): string
    {
        return 'giveaway';
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}
