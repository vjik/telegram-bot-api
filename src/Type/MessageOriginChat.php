<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#messageoriginchat
 */
final readonly class MessageOriginChat implements MessageOrigin
{
    public function __construct(
        public DateTimeImmutable $date,
        public Chat $senderChat,
        public ?string $authorSignature = null,
    ) {
    }

    public function getType(): string
    {
        return 'chat';
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getDateTimeImmutable($result, 'date', $raw),
            array_key_exists('sender_chat', $result)
                ? Chat::fromTelegramResult($result['sender_chat'], $raw)
                : throw new NotFoundKeyInResultException('sender_chat', $raw),
            ValueHelper::getStringOrNull($result, 'author_signature', $raw),
        );
    }
}
