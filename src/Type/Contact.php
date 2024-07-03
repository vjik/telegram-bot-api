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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'phone_number', $raw),
            ValueHelper::getString($result, 'first_name', $raw),
            ValueHelper::getStringOrNull($result, 'last_name', $raw),
            ValueHelper::getIntegerOrNull($result, 'user_id', $raw),
            ValueHelper::getStringOrNull($result, 'vcard', $raw),
        );
    }
}
