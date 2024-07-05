<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#businessconnection
 */
final readonly class BusinessConnection
{
    public function __construct(
        public string $id,
        public User $user,
        public int $userChatId,
        public DateTimeImmutable $date,
        public bool $canReply,
        public bool $isEnabled,
    ) {
    }
}
