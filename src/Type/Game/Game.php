<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Game;

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
}
