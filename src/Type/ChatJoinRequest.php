<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatjoinrequest
 */
final readonly class ChatJoinRequest
{
    public function __construct(
        public Chat $chat,
        public User $from,
        public int $userChatId,
        public DateTimeImmutable $date,
        public ?string $bio = null,
        public ?ChatInviteLink $inviteLink = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'], $raw)
                : throw new NotFoundKeyInResultException('chat', $raw),
            array_key_exists('from', $result)
                ? User::fromTelegramResult($result['from'], $raw)
                : throw new NotFoundKeyInResultException('from', $raw),
            ValueHelper::getInteger($result, 'user_chat_id', $raw),
            ValueHelper::getDateTimeImmutable($result, 'date', $raw),
            ValueHelper::getStringOrNull($result, 'bio', $raw),
            array_key_exists('invite_link', $result)
                ? ChatInviteLink::fromTelegramResult($result['invite_link'], $raw)
                : null,
        );
    }
}
