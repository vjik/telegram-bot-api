<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#paidmediaphoto
 */
final readonly class PaidMediaPhoto implements PaidMedia
{
    /**
     * @param PhotoSize[] $photo
     */
    public function __construct(
        public array $photo,
    ) {
    }

    public function getType(): string
    {
        return 'photo';
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getArrayOfPhotoSizes($result, 'photo', $raw),
        );
    }
}
