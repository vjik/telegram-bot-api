<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
final readonly class InlineKeyboardMarkup
{
    /**
     * @param array[] $inlineKeyboard
     * @psalm-param array<array-key, array<array-key, InlineKeyboardButton>> $inlineKeyboard
     */
    public function __construct(
        public array $inlineKeyboard,
    ) {
    }

    public function toRequestArray(): array
    {
        return [
            'inline_keyboard' => array_map(
                static fn(array $buttons) => array_map(
                    static fn(InlineKeyboardButton $button) => $button->toRequestArray(),
                    $buttons
                ),
                $this->inlineKeyboard
            ),
        ];
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getArrayOfArrayOfInlineKeyboardButtons($result, 'inline_keyboard'),
        );
    }
}
