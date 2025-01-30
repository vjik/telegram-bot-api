<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfArraysOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#userprofilephotos
 *
 * @api
 */
final readonly class UserProfilePhotos
{
    /**
     * @param array[] $photos
     * @psalm-param array<array-key, array<array-key, PhotoSize>> $photos
     */
    public function __construct(
        public int $totalCount,
        #[ArrayOfArraysOfObjectsValue(PhotoSize::class)]
        public array $photos,
    ) {}
}
