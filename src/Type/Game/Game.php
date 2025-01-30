<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Game;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Vjik\TelegramBot\Api\Type\Animation;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\PhotoSize;

/**
 * @see https://core.telegram.org/bots/api#game
 *
 * @api
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
        #[ArrayOfObjectsValue(PhotoSize::class)]
        public array $photo,
        public ?string $text = null,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $textEntities = null,
        public ?Animation $animation = null,
    ) {}
}
