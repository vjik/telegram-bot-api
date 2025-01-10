<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\InputFileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputpaidmediaphoto
 */
final readonly class InputPaidMediaPhoto implements InputPaidMedia
{
    public function __construct(
        public string|InputFile $media,
    ) {}

    public function getType(): string
    {
        return 'photo';
    }

    public function toRequestArray(?InputFileCollector $fileCollector = null): array
    {
        if ($fileCollector !== null) {
            $media = $this->media instanceof InputFile
                ? 'attach://' . $fileCollector->add($this->media)
                : $this->media;
        } else {
            $media = $this->media;
        }

        return [
            'type' => $this->getType(),
            'media' => $media,
        ];
    }
}
