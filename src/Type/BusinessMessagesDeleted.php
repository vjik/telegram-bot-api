<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'business_connection_id'),
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'])
                : throw new NotFoundKeyInResultException('chat'),
            ValueHelper::getArrayOfIntegers($result, 'message_ids'),
        );
    }
}
