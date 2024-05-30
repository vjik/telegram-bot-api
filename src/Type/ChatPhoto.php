<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatphoto
 */
final readonly class ChatPhoto
{
    public function __construct(
        public string $smallFileId,
        public string $smallFileUniqueId,
        public string $bigFileId,
        public string $bigFileUniqueId,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'small_file_id'),
            ValueHelper::getString($result, 'small_file_unique_id'),
            ValueHelper::getString($result, 'big_file_id'),
            ValueHelper::getString($result, 'big_file_unique_id'),
        );
    }
}
