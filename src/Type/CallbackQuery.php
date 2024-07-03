<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#callbackquery
 */
final readonly class CallbackQuery
{
    public function __construct(
        public string $id,
        public User $from,
        public string $chatInstance,
        public Message|InaccessibleMessage|null $message = null,
        public ?string $inlineMessageId = null,
        public ?string $data = null,
        public ?string $gameShortName = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'id', $raw),
            array_key_exists('from', $result)
                ? User::fromTelegramResult($result['from'], $raw)
                : throw new NotFoundKeyInResultException('from', $raw),
            ValueHelper::getString($result, 'chat_instance', $raw),
            array_key_exists('message', $result)
                ? MaybeInaccessibleMessageFactory::fromTelegramResult($result['message'], $raw)
                : null,
            ValueHelper::getStringOrNull($result, 'inline_message_id', $raw),
            ValueHelper::getStringOrNull($result, 'data', $raw),
            ValueHelper::getStringOrNull($result, 'game_short_name', $raw),
        );
    }
}
