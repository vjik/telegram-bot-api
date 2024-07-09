<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;

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
    ) {}

    public function getType(): string
    {
        return 'channel';
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
