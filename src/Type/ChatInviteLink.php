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
        public string $inviteLink,
        public User $creator,
        public bool $createsJoinRequest,
        public bool $isPrimary,
        public bool $isRevoked,
        public ?string $name = null,
        public ?DateTimeImmutable $expireDate = null,
        public ?int $memberLimit = null,
        public ?int $pendingJoinRequestCount = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'invite_link', $raw),
            array_key_exists('creator', $result)
                ? User::fromTelegramResult($result['creator'], $raw)
                : throw new NotFoundKeyInResultException('creator', $raw),
            ValueHelper::getBoolean($result, 'creates_join_request', $raw),
            ValueHelper::getBoolean($result, 'is_primary', $raw),
            ValueHelper::getBoolean($result, 'is_revoked', $raw),
            ValueHelper::getStringOrNull($result, 'name', $raw),
            ValueHelper::getDateTimeImmutableOrNull($result, 'expire_date', $raw),
            ValueHelper::getIntegerOrNull($result, 'member_limit', $raw),
            ValueHelper::getIntegerOrNull($result, 'pending_join_request_count', $raw),
        );
    }
}
