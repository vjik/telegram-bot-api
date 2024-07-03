<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatboostsourcegiveaway
 */
final readonly class ChatBoostSourceGiveaway implements ChatBoostSource
{
    public function __construct(
        public int $giveawayMessageId,
        public ?User $user = null,
        public ?true $isUnclaimed = null,
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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getInteger($result, 'giveaway_message_id', $raw),
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'], $raw)
                : null,
            ValueHelper::getTrueOrNull($result, 'is_unclaimed', $raw),
        );
    }
}
