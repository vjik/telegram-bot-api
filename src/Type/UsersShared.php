<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getInteger($result, 'request_id', $raw),
            ValueHelper::getArrayOfSharedUsers($result, 'users', $raw),
        );
    }
}
