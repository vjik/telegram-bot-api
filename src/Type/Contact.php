<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#contact
 */
final readonly class Contact
{
    public function __construct(
        public string $phoneNumber,
        public string $firstName,
        public ?string $lastName = null,
        public ?int $userId = null,
        public ?string $vcard = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'phone_number'),
            ValueHelper::getString($result, 'first_name'),
            ValueHelper::getStringOrNull($result, 'last_name'),
            ValueHelper::getIntegerOrNull($result, 'user_id'),
            ValueHelper::getStringOrNull($result, 'vcard'),
        );
    }
}
