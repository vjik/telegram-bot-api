<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

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
    ) {}
}
