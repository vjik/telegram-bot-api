<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#linkpreviewoptions
 */
final readonly class LinkPreviewOptions
{
    public function __construct(
        public ?bool $isDisabled,
        public ?string $url,
        public ?bool $preferSmallMedia,
        public ?bool $preferLargeMedia,
        public ?bool $showAboveText,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getBooleanOrNull($result, 'is_disabled'),
            ValueHelper::getStringOrNull($result, 'url'),
            ValueHelper::getBooleanOrNull($result, 'prefer_small_media'),
            ValueHelper::getBooleanOrNull($result, 'prefer_large_media'),
            ValueHelper::getBooleanOrNull($result, 'show_above_text'),
        );
    }
}
