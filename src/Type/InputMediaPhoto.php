<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\RequestFileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputmediaphoto
 */
final readonly class InputMediaPhoto implements InputMedia
{
    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        public string|InputFile $media,
        public ?string $caption = null,
        public ?string $parseMode = null,
        public ?array $captionEntities = null,
        public ?bool $showCaptionAboveMedia = null,
        public ?bool $hasSpoiler = null,
    ) {}

    public function getType(): string
    {
        return 'photo';
    }

    public function toRequestArray(?RequestFileCollector $fileCollector = null): array
    {
        if ($fileCollector !== null) {
            $media = $this->media instanceof InputFile
                ? 'attach://' . $fileCollector->add($this->media)
                : $this->media;
        } else {
            $media = $this->media;
        }

        return array_filter(
            [
                'type' => $this->getType(),
                'media' => $media,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'show_caption_above_media' => $this->showCaptionAboveMedia,
                'has_spoiler' => $this->hasSpoiler,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
