<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#reactiontypecustomemoji
 */
final readonly class ReactionTypeCustomEmoji implements ReactionType
{
    public function __construct(
        public string $customEmojiId,
    ) {
    }

    public function getType(): string
    {
        return 'custom_emoji';
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'custom_emoji_id'),
        );
    }
}
