<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\SuggestedPostParameters;

/**
 * @see https://core.telegram.org/bots/api#forwardmessage
 *
 * @template-implements MethodInterface<Message>
 */
final readonly class ForwardMessage implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int|string $fromChatId,
        private int $messageId,
        private ?int $messageThreadId = null,
        private ?bool $disableNotification = null,
        private ?bool $protectContent = null,
        private ?int $videoStartTimestamp = null,
        private ?int $directMessagesTopicId = null,
        private ?SuggestedPostParameters $suggestedPostParameters = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'forwardMessage';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'direct_messages_topic_id' => $this->directMessagesTopicId,
                'from_chat_id' => $this->fromChatId,
                'video_start_timestamp' => $this->videoStartTimestamp,
                'disable_notification' => $this->disableNotification,
                'protect_content' => $this->protectContent,
                'suggested_post_parameters' => $this->suggestedPostParameters?->toRequestArray(),
                'message_id' => $this->messageId,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(Message::class);
    }
}
