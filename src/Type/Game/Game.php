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
        public ?string $text = null,
        public ?array $textEntities = null,
        public ?Animation $animation = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'title', $raw),
            ValueHelper::getString($result, 'description', $raw),
            ValueHelper::getArrayOfPhotoSizes($result, 'photo', $raw),
            ValueHelper::getStringOrNull($result, 'text', $raw),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'text_entities', $raw),
            array_key_exists('animation', $result)
                ? Animation::fromTelegramResult($result['animation'], $raw)
                : null,
        );
    }
}
