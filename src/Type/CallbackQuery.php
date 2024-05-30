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
        public Message|InaccessibleMessage|null $message,
        public ?string $inlineMessageId,
        public string $chatInstance,
        public ?string $data,
        public ?string $gameShortName,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'id'),
            array_key_exists('from', $result)
                ? User::fromTelegramResult($result['from'])
                : throw new NotFoundKeyInResultException('from'),
            array_key_exists('message', $result)
                ? MaybeInaccessibleMessageFactory::fromTelegramResult($result['message'])
                : throw new NotFoundKeyInResultException('message'),
            ValueHelper::getStringOrNull($result, 'inline_message_id'),
            ValueHelper::getString($result, 'chat_instance'),
            ValueHelper::getStringOrNull($result, 'data'),
            ValueHelper::getStringOrNull($result, 'game_short_name'),
        );
    }
}
