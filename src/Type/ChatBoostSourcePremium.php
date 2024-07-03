<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatboostsourcepremium
 */
final readonly class ChatBoostSourcePremium implements ChatBoostSource
{
    public function __construct(
        public User $user,
    ) {
    }

    public function getSource(): string
    {
        return 'premium';
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'], $raw)
                : throw new NotFoundKeyInResultException('user', $raw),
        );
    }
}
