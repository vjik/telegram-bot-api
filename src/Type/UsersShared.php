<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#usersshared
 */
final readonly class UsersShared
{
    /**
     * @param int $requestId
     * @param SharedUser[] $users
     */
    public function __construct(
        public int $requestId,
        public array $users,
    ) {
    }
}
