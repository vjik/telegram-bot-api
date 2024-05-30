<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final readonly class BackgroundTypeWallpaper implements BackgroundType
{

    public function __construct(
        public Document $document,
        public int $darkThemeDimming,
        public ?true $isBlurred,
        public ?true $isMoving,
    ) {
    }

    function getType(): string
    {
        return 'wallpaper';
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('document', $result)
                ? Document::fromTelegramResult($result['document'])
                : throw new NotFoundKeyInResultException('document'),
            ValueHelper::getInteger($result, 'dark_theme_dimming'),
            ValueHelper::getTrueOrNull($result, 'is_blurred'),
            ValueHelper::getTrueOrNull($result, 'is_moving'),
        );
    }
}
