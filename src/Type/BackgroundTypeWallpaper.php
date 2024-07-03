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
        public ?true $isBlurred = null,
        public ?true $isMoving = null,
    ) {
    }

    function getType(): string
    {
        return 'wallpaper';
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('document', $result)
                ? Document::fromTelegramResult($result['document'], $raw)
                : throw new NotFoundKeyInResultException('document', $raw),
            ValueHelper::getInteger($result, 'dark_theme_dimming', $raw),
            ValueHelper::getTrueOrNull($result, 'is_blurred', $raw),
            ValueHelper::getTrueOrNull($result, 'is_moving', $raw),
        );
    }
}
