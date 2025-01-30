<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Passport;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#passportdata
 *
 * @api
 */
final readonly class PassportData
{
    /**
     * @param EncryptedPassportElement[] $data
     */
    public function __construct(
        #[ArrayOfObjectsValue(EncryptedPassportElement::class)]
        public array $data,
        public EncryptedCredentials $credentials,
    ) {}
}
