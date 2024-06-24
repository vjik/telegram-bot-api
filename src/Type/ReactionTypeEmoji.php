<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#reactiontypeemoji
 */
final readonly class ReactionTypeEmoji implements ReactionType
{
    public function __construct(
        public string $emoji,
    ) {
    }

    public function getType(): string
    {
        return 'emoji';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'emoji' => $this->emoji,
        ];
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'emoji'),
        );
    }
}
