<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Game;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\Animation;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\PhotoSize;

/**
 * @see https://core.telegram.org/bots/api#game
 */
final readonly class Game
{
    /**
     * @param PhotoSize[] $photo
     * @param MessageEntity[] $textEntities
     */
    public function __construct(
        public string $title,
        public string $description,
        public array $photo,
        public ?string $text,
        public ?array $textEntities,
        public ?Animation $animation,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'title'),
            ValueHelper::getString($result, 'description'),
            ValueHelper::getArrayOfPhotoSizes($result, 'photo'),
            ValueHelper::getStringOrNull($result, 'text'),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'text_entities'),
            array_key_exists('animation', $result)
                ? Animation::fromTelegramResult($result['animation'])
                : null,
        );
    }
}
