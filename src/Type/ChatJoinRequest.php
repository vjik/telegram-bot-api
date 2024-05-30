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
        public ?string $bio,
        public ?ChatInviteLink $inviteLink,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'])
                : throw new NotFoundKeyInResultException('chat'),
            array_key_exists('from', $result)
                ? User::fromTelegramResult($result['from'])
                : throw new NotFoundKeyInResultException('from'),
            ValueHelper::getInteger($result, 'user_chat_id'),
            ValueHelper::getDateTimeImmutable($result, 'date'),
            ValueHelper::getStringOrNull($result, 'bio'),
            array_key_exists('invite_link', $result)
                ? ChatInviteLink::fromTelegramResult($result['invite_link'])
                : null,
        );
    }
}
