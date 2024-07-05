<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfValueProcessors;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\IntegerValue;

/**
 * @see https://core.telegram.org/bots/api#businessmessagesdeleted
 */
final readonly class BusinessMessagesDeleted
{
    /**
     * @param int[] $messageIds
     */
    public function __construct(
        public string $businessConnectionId,
        public Chat $chat,
        #[ArrayOfValueProcessors(IntegerValue::class)]
        public array $messageIds,
    ) {
    }
}
