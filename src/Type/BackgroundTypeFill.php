<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#backgroundtypefill
 */
final readonly class BackgroundTypeFill implements BackgroundType
{
    public function __construct(
        public BackgroundFill $fill,
        public int $darkThemeDimming,
    ) {
    }

    function getType(): string
    {
        return 'fill';
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('fill', $result)
                ? BackgroundFillFactory::fromTelegramResult($result['fill'], $raw)
                : throw new NotFoundKeyInResultException('fill', $raw),
            ValueHelper::getInteger($result, 'dark_theme_dimming', $raw),
        );
    }
}
