<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#callbackquery
 */
final readonly class CallbackQuery
{
    public function __construct(
        public string $id,
        public User $from,
        public Message|InaccessibleMessage|null $message,
        public ?string $inlineMessageId,
        public string $chatInstance,
        public ?string $data,
        public ?string $gameShortName,
    ) {
    }
}
