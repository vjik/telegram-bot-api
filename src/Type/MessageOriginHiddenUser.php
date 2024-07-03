<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#messageoriginhiddenuser
 */
final readonly class MessageOriginHiddenUser implements MessageOrigin
{
    public function __construct(
        public DateTimeImmutable $date,
        public string $senderUserName,
    ) {
    }

    public function getType(): string
    {
        return 'hidden_user';
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
            ValueHelper::getString($result, 'sender_user_name', $raw),
        );
    }
}
