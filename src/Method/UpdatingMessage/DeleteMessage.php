<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\UpdatingMessage;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestInterface;

/**
 * @see https://core.telegram.org/bots/api#deletemessage
 *
 * @template-implements TelegramRequestInterface<TrueValue>
 */
final readonly class DeleteMessage implements TelegramRequestInterface
{
    public function __construct(
        private int|string $chatId,
        private int $messageId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteMessage';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'message_id' => $this->messageId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
