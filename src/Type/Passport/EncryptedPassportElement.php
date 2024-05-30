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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'type'),
            ValueHelper::getStringOrNull($result, 'data'),
            ValueHelper::getStringOrNull($result, 'phone_number'),
            ValueHelper::getStringOrNull($result, 'email'),
            ValueHelper::getArrayOfPassportFilesOrNull($result, 'files'),
            array_key_exists('front_side', $result)
                ? PassportFile::fromTelegramResult($result['front_side'])
                : null,
            array_key_exists('reverse_side', $result)
                ? PassportFile::fromTelegramResult($result['reverse_side'])
                : null,
            array_key_exists('selfie', $result)
                ? PassportFile::fromTelegramResult($result['selfie'])
                : null,
            ValueHelper::getArrayOfPassportFilesOrNull($result, 'translation'),
            ValueHelper::getString($result, 'hash'),
        );
    }
}
