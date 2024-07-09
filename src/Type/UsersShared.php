<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;

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
        #[ArrayOfObjectsValue(SharedUser::class)]
        public array $users,
    ) {}
}
