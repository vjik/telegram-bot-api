<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#messageoriginchannel
 */
final readonly class MessageOriginChannel implements MessageOrigin
{
    public function __construct(
        public DateTimeImmutable $date,
        public Chat $chat,
        public int $messageId,
        public ?string $authorSignature = null,
    ) {
    }

    public function getType(): string
    {
        return 'channel';
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getDateTimeImmutable($result, 'date'),
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'])
                : throw new NotFoundKeyInResultException('chat'),
            ValueHelper::getInteger($result, 'message_id'),
            ValueHelper::getStringOrNull($result, 'author_signature'),
        );
    }
}
