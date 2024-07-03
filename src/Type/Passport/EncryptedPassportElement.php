<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Passport;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#encryptedpassportelement
 */
final readonly class EncryptedPassportElement
{
    /**
     * @param PassportFile[]|null $files
     * @param PassportFile[]|null $translation
     */
    public function __construct(
        public string $type,
        public string $hash,
        public ?string $data = null,
        public ?string $phoneNumber = null,
        public ?string $email = null,
        public ?array $files = null,
        public ?PassportFile $frontSide = null,
        public ?PassportFile $reverseSide = null,
        public ?PassportFile $selfie = null,
        public ?array $translation = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'type', $raw),
            ValueHelper::getString($result, 'hash', $raw),
            ValueHelper::getStringOrNull($result, 'data', $raw),
            ValueHelper::getStringOrNull($result, 'phone_number', $raw),
            ValueHelper::getStringOrNull($result, 'email', $raw),
            ValueHelper::getArrayOfPassportFilesOrNull($result, 'files', $raw),
            array_key_exists('front_side', $result)
                ? PassportFile::fromTelegramResult($result['front_side'], $raw)
                : null,
            array_key_exists('reverse_side', $result)
                ? PassportFile::fromTelegramResult($result['reverse_side'], $raw)
                : null,
            array_key_exists('selfie', $result)
                ? PassportFile::fromTelegramResult($result['selfie'], $raw)
                : null,
            ValueHelper::getArrayOfPassportFilesOrNull($result, 'translation', $raw),
        );
    }
}
