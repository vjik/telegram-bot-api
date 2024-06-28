<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#userchatboosts
 */
final readonly class UserChatBoosts
{
    /**
     * @param ChatBoost[] $boosts
     */
    public function __construct(
        public array $boosts,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getArrayOfChatBoosts($result, 'boosts'),
        );
    }
}
