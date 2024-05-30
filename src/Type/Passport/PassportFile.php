<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Passport;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#passportfile
 */
final readonly class PassportFile
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public int $fileSize,
        public DateTimeImmutable $fileDate,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'file_id'),
            ValueHelper::getString($result, 'file_unique_id'),
            ValueHelper::getInteger($result, 'file_size'),
            ValueHelper::getDateTimeImmutable($result, 'file_date'),
        );
    }
}
