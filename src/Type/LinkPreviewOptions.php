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
        public ?bool $isDisabled = null,
        public ?string $url = null,
        public ?bool $preferSmallMedia = null,
        public ?bool $preferLargeMedia = null,
        public ?bool $showAboveText = null,
    ) {
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'is_disabled' => $this->isDisabled,
                'url' => $this->url,
                'prefer_small_media' => $this->preferSmallMedia,
                'prefer_large_media' => $this->preferLargeMedia,
                'show_above_text' => $this->showAboveText,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
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
