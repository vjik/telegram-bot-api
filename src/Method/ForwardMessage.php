<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Message;

/**
 * @see https://core.telegram.org/bots/api#forwardmessage
 */
final readonly class ForwardMessage implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private int|string $fromChatId,
        private int $messageId,
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
        return 'forwardMessage';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'from_chat_id' => $this->fromChatId,
                'disable_notification' => $this->disableNotification,
                'protect_content' => $this->protectContent,
                'message_id' => $this->messageId,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function prepareResult(mixed $result): Message
    {
        return Message::fromTelegramResult($result);
    }
}
