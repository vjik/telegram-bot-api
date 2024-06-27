<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Sticker;

use Vjik\TelegramBot\Api\Constant\Sticker\StickerType;
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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'file_id'),
            ValueHelper::getString($result, 'file_unique_id'),
            ValueHelper::getString($result, 'type'),
            ValueHelper::getInteger($result, 'width'),
            ValueHelper::getInteger($result, 'height'),
            ValueHelper::getBoolean($result, 'is_animated'),
            ValueHelper::getBoolean($result, 'is_video'),
            array_key_exists('thumbnail', $result) ? PhotoSize::fromTelegramResult($result['thumbnail']) : null,
            ValueHelper::getStringOrNull($result, 'emoji'),
            ValueHelper::getStringOrNull($result, 'set_name'),
            array_key_exists('premium_animation', $result)
                ? File::fromTelegramResult($result['premium_animation'])
                : null,
            array_key_exists('mask_position', $result)
                ? MaskPosition::fromTelegramResult($result['mask_position'])
                : null,
            ValueHelper::getStringOrNull($result, 'custom_emoji_id'),
            ValueHelper::getTrueOrNull($result, 'needs_repainting'),
            ValueHelper::getIntegerOrNull($result, 'file_size'),
        );
    }
}
