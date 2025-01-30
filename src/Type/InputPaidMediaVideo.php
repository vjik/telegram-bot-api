<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputpaidmediavideo
 *
 * @api
 */
final readonly class InputPaidMediaVideo implements InputPaidMedia
{
    public function __construct(
        public InputFile|string $media,
        public InputFile|string|null $thumbnail = null,
        public ?int $width = null,
        public ?int $height = null,
        public ?int $duration = null,
        public ?bool $supportsStreaming = null,
    ) {}

    public function getType(): string
    {
        return 'video';
    }

    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        if ($fileCollector !== null) {
            $media = $this->media instanceof InputFile
                ? 'attach://' . $fileCollector->add($this->media)
                : $this->media;
            $thumbnail = $this->thumbnail instanceof InputFile
                ? 'attach://' . $fileCollector->add($this->thumbnail)
                : $this->thumbnail;
        } else {
            $media = $this->media;
            $thumbnail = $this->thumbnail;
        }

        return array_filter(
            [
                'type' => $this->getType(),
                'media' => $media,
                'thumbnail' => $thumbnail,
                'width' => $this->width,
                'height' => $this->height,
                'duration' => $this->duration,
                'supports_streaming' => $this->supportsStreaming,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
