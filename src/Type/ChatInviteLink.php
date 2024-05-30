<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatinvitelink
 */
final readonly class ChatInviteLink
{
    public function __construct(
        public string $inviteLlink,
        public User $creator,
        public bool $createsJoinRequest,
        public bool $isPrimary,
        public bool $isRevoked,
        public ?string $name,
        public ?DateTimeImmutable $expireDate,
        public ?int $memberLimit,
        public ?int $pendingJoinRequestCount,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'invite_link'),
            array_key_exists('creator', $result)
                ? User::fromTelegramResult($result['creator'])
                : throw new NotFoundKeyInResultException('creator'),
            ValueHelper::getBoolean($result, 'creates_join_request'),
            ValueHelper::getBoolean($result, 'is_primary'),
            ValueHelper::getBoolean($result, 'is_revoked'),
            ValueHelper::getStringOrNull($result, 'name'),
            ValueHelper::getDateTimeImmutableOrNull($result, 'expire_date'),
            ValueHelper::getIntegerOrNull($result, 'member_limit'),
            ValueHelper::getIntegerOrNull($result, 'pending_join_request_count'),
        );
    }
}
