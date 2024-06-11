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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getInteger($result, 'total_count'),
            ValueHelper::getArrayOfArrayOfPhotoSize($result, 'photos'),
        );
    }
}
