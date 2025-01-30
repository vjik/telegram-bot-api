<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Sticker;

use Vjik\TelegramBot\Api\FileCollector;
use Vjik\TelegramBot\Api\Type\InputFile;

/**
 * @see https://core.telegram.org/bots/api#inputsticker
 *
 * @api
 */
final readonly class InputSticker
{
    /**
     * @param string[] $emojiList
     * @param string[] $keywords
     */
    public function __construct(
        private InputFile|string $sticker,
        private string $format,
        private array $emojiList,
        private ?MaskPosition $maskPosition = null,
        private ?array $keywords = null,
    ) {}

    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        if ($fileCollector !== null) {
            $sticker = $this->sticker instanceof InputFile
                ? 'attach://' . $fileCollector->add($this->sticker)
                : $this->sticker;
        } else {
            $sticker = $this->sticker;
        }

        return array_filter(
            [
                'sticker' => $sticker,
                'format' => $this->format,
                'emoji_list' => $this->emojiList,
                'mask_position' => $this->maskPosition?->toRequestArray(),
                'keywords' => $this->keywords,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
