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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('document', $result)
                ? Document::fromTelegramResult($result['document'])
                : throw new NotFoundKeyInResultException('document'),
            array_key_exists('fill', $result)
                ? BackgroundFillFactory::fromTelegramResult($result['fill'])
                : throw new NotFoundKeyInResultException('fill'),
            ValueHelper::getInteger($result, 'intensity'),
            ValueHelper::getTrueOrNull($result, 'is_inverted'),
            ValueHelper::getTrueOrNull($result, 'is_moving'),
        );
    }
}
