<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\InputChecklist;
use Vjik\TelegramBot\Api\Type\Message;

/**
 * @see https://core.telegram.org/bots/api#editmessagechecklist
 *
 * @template-implements MethodInterface<Message>
 */
final readonly class EditMessageChecklist implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private int $chatId,
        private int $messageId,
        private InputChecklist $checklist,
        private ?InlineKeyboardMarkup $replyMarkup = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'editMessageChecklist';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_id' => $this->messageId,
                'checklist' => $this->checklist->toRequestArray(),
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(Message::class);
    }
}
