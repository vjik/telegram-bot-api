<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatmemberupdated
 */
final readonly class ChatMemberUpdated
{
    public function __construct(
        public Chat $chat,
        public User $from,
        public DateTimeImmutable $date,
        public ChatMember $oldChatMember,
        public ChatMember $newChatMember,
        public ?ChatInviteLink $inviteLink = null,
        public ?bool $viaJoinRequest = null,
        public ?bool $viaChatFolderInviteLink = null,
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
            ValueHelper::getDateTimeImmutable($result, 'date', $raw),
            array_key_exists('old_chat_member', $result)
                ? ChatMemberFactory::fromTelegramResult($result['old_chat_member'], $raw)
                : throw new NotFoundKeyInResultException('old_chat_member', $raw),
            array_key_exists('new_chat_member', $result)
                ? ChatMemberFactory::fromTelegramResult($result['new_chat_member'], $raw)
                : throw new NotFoundKeyInResultException('new_chat_member', $raw),
            array_key_exists('invite_link', $result)
                ? ChatInviteLink::fromTelegramResult($result['invite_link'], $raw)
                : null,
            ValueHelper::getBooleanOrNull($result, 'via_join_request', $raw),
            ValueHelper::getBooleanOrNull($result, 'via_chat_folder_invite_link', $raw),
        );
    }
}
