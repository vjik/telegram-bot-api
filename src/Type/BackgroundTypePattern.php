<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#backgroundtypepattern
 */
final readonly class BackgroundTypePattern implements BackgroundType
{
    public function __construct(
        public Document $document,
        public BackgroundFill $fill,
        public int $intensity,
        public ?true $isInverted = null,
        public ?true $isMoving = null,
    ) {
    }

    function getType(): string
    {
        return 'pattern';
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('document', $result)
                ? Document::fromTelegramResult($result['document'], $raw)
                : throw new NotFoundKeyInResultException('document', $raw),
            array_key_exists('fill', $result)
                ? BackgroundFillFactory::fromTelegramResult($result['fill'], $raw)
                : throw new NotFoundKeyInResultException('fill', $raw),
            ValueHelper::getInteger($result, 'intensity', $raw),
            ValueHelper::getTrueOrNull($result, 'is_inverted', $raw),
            ValueHelper::getTrueOrNull($result, 'is_moving', $raw),
        );
    }
}
