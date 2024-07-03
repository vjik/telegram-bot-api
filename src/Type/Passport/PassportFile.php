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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'file_id', $raw),
            ValueHelper::getString($result, 'file_unique_id', $raw),
            ValueHelper::getInteger($result, 'file_size', $raw),
            ValueHelper::getDateTimeImmutable($result, 'file_date', $raw),
        );
    }
}
