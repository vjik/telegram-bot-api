<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\File;
use Vjik\TelegramBot\Api\Type\PhotoSize;

/**
 * @see https://core.telegram.org/bots/api#sticker
 */
final readonly class Sticker
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public string $type,
        public int $width,
        public int $height,
        public bool $isAnimated,
        public bool $isVideo,
        public ?PhotoSize $thumbnail = null,
        public ?string $emoji = null,
        public ?string $setName = null,
        public ?File $premiumAnimation = null,
        public ?MaskPosition $maskPosition = null,
        public ?string $customEmojiId = null,
        public ?bool $needsRepainting = null,
        public ?int $fileSize = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'file_id', $raw),
            ValueHelper::getString($result, 'file_unique_id', $raw),
            ValueHelper::getString($result, 'type', $raw),
            ValueHelper::getInteger($result, 'width', $raw),
            ValueHelper::getInteger($result, 'height', $raw),
            ValueHelper::getBoolean($result, 'is_animated', $raw),
            ValueHelper::getBoolean($result, 'is_video', $raw),
            array_key_exists('thumbnail', $result)
                ? PhotoSize::fromTelegramResult($result['thumbnail'], $raw)
                : null,
            ValueHelper::getStringOrNull($result, 'emoji', $raw),
            ValueHelper::getStringOrNull($result, 'set_name', $raw),
            array_key_exists('premium_animation', $result)
                ? File::fromTelegramResult($result['premium_animation'], $raw)
                : null,
            array_key_exists('mask_position', $result)
                ? MaskPosition::fromTelegramResult($result['mask_position'], $raw)
                : null,
            ValueHelper::getStringOrNull($result, 'custom_emoji_id', $raw),
            ValueHelper::getTrueOrNull($result, 'needs_repainting', $raw),
            ValueHelper::getIntegerOrNull($result, 'file_size', $raw),
        );
    }
}
