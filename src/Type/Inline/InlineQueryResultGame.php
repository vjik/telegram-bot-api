<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Inline;

use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;

/**
 * @see https://core.telegram.org/bots/api#inlinequeryresultgame
 */
final readonly class InlineQueryResultGame implements InlineQueryResult
{
    public function __construct(
        public string $id,
        public string $gameShortName,
        public ?InlineKeyboardMarkup $replyMarkup = null,
    ) {}

    public function getType(): string
    {
        return 'game';
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'id' => $this->id,
                'game_short_name' => $this->gameShortName,
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
