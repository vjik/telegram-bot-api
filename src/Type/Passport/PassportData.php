<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Passport;

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
}
