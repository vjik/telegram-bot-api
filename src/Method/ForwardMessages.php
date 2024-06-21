<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\MessageId;

/**
 * @see https://core.telegram.org/bots/api#forwardmessages
 */
final readonly class ForwardMessages implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param int[] $messageIds
     */
    public function __construct(
        private int|string $chatId,
        private int|string $fromChatId,
        private array $messageIds,
        private ?int $messageThreadId = null,
        private ?bool $disableNotification = null,
        private ?bool $protectContent = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'forwardMessages';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'from_chat_id' => $this->fromChatId,
                'message_ids' => $this->messageIds,
                'disable_notification' => $this->disableNotification,
                'protect_content' => $this->protectContent,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    /**
     * @return MessageId[]
     */
    public function prepareResult(mixed $result): array
    {
        ValueHelper::assertArrayResult($result);
        return array_map(
            static fn($item) => MessageId::fromTelegramResult($item),
            $result
        );
    }
}
