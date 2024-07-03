<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Passport;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#passportdata
 */
final readonly class PassportData
{
    /**
     * @param EncryptedPassportElement[] $data
     */
    public function __construct(
        public array $data,
        public EncryptedCredentials $credentials,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getArrayOfEncryptedPassportElements($result, 'data', $raw),
            EncryptedCredentials::fromTelegramResult($result['credentials'], $raw),
        );
    }
}
