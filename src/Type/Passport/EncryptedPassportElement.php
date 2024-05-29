<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Passport;

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
        public ?string $data,
        public ?string $phoneNumber,
        public ?string $email,
        public ?array $files,
        public ?PassportFile $frontSide,
        public ?PassportFile $reverseSide,
        public ?PassportFile $selfie,
        public ?array $translation,
        public string $hash,
    ) {
    }
}
