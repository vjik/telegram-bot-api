<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatmembermember
 */
final readonly class ChatMemberMember implements ChatMember
{
    public function __construct(
        public User $user,
    ) {
    }

    public function getStatus(): string
    {
        return 'member';
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'])
                : throw new NotFoundKeyInResultException('user'),
        );
    }
}
