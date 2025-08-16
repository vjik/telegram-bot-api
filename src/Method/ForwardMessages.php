<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\MessageId;

/**
 * @see https://core.telegram.org/bots/api#forwardmessages
 *
 * @template-implements MethodInterface<array<MessageId>>
 */
final readonly class ForwardMessages implements MethodInterface
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
        private ?int $directMessagesTopicId = null,
    ) {}

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
                'direct_messages_topic_id' => $this->directMessagesTopicId,
                'from_chat_id' => $this->fromChatId,
                'message_ids' => $this->messageIds,
                'disable_notification' => $this->disableNotification,
                'protect_content' => $this->protectContent,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ArrayOfObjectsValue
    {
        return new ArrayOfObjectsValue(MessageId::class);
    }
}
