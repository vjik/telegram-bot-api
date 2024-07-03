<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Passport;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#encryptedcredentials
 */
final readonly class EncryptedCredentials
{
    public function __construct(
        public string $data,
        public string $hash,
        public string $secret,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'data', $raw),
            ValueHelper::getString($result, 'hash', $raw),
            ValueHelper::getString($result, 'secret', $raw),
        );
    }
}
