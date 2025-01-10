<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\UpdatingMessage;

use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\Poll;

/**
 * @see https://core.telegram.org/bots/api#stoppoll
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<class-string<Poll>>
 */
final readonly class StopPoll implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private int $messageId,
        private ?string $businessConnectionId = null,
        private ?InlineKeyboardMarkup $replyMarkup = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'stopPoll';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_id' => $this->messageId,
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): string
    {
        return Poll::class;
    }
}
