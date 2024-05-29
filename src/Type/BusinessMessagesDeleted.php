<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#businessmessagesdeleted
 */
final readonly class BusinessMessagesDeleted
{
    /**
     * @param string $businessConnectionId
     * @param Chat $chat
     * @param int[] $messageIds
     */
    public function __construct(
        public string $businessConnectionId,
        public Chat $chat,
        public array $messageIds,
    ) {
    }
}
