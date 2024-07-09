<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#pinchatmessage
 */
final readonly class PinChatMessage implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private int $messageId,
        private ?bool $disableNotification = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'pinChatMessage';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'message_id' => $this->messageId,
                'disable_notification' => $this->disableNotification,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
