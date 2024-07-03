<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#userprofilephotos
 */
final readonly class UserProfilePhotos
{
    /**
     * @param array[] $photos
     * @psalm-param array<array-key, array<array-key, PhotoSize>> $photos
     */
    public function __construct(
        public int $totalCount,
        public array $photos,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getInteger($result, 'total_count', $raw),
            ValueHelper::getArrayOfArrayOfPhotoSize($result, 'photos', $raw),
        );
    }
}
