<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#reactioncount
 */
final readonly class ReactionCount
{
    public function __construct(
        public ReactionType $type,
        public int $totalCount,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('type', $result)
                ? ReactionTypeFactory::fromTelegramResult($result['type'], $raw)
                : throw new NotFoundKeyInResultException('type', $raw),
            ValueHelper::getInteger($result, 'total_count', $raw),
        );
    }
}
