<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\MessageId;

/**
 * @see https://core.telegram.org/bots/api#copymessages
 */
final readonly class CopyMessages implements TelegramRequestWithResultPreparingInterface
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
        private ?bool $removeCaption = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'copyMessages';
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
                'remove_caption' => $this->removeCaption,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ArrayOfObjectsValue
    {
        return new ArrayOfObjectsValue(MessageId::class);
    }
}
