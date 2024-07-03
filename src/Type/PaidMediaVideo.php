<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#paidmediavideo
 */
final readonly class PaidMediaVideo implements PaidMedia
{
    public function __construct(
        public Video $video,
    ) {
    }

    public function getType(): string
    {
        return 'video';
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('video', $result)
                ? Video::fromTelegramResult($result['video'], $raw)
                : throw new NotFoundKeyInResultException('video', $raw),
        );
    }
}
