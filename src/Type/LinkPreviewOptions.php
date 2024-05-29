<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

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
}
