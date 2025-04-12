<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\UpdatingMessage;

use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

/**
 * @see https://core.telegram.org/bots/api#readbusinessmessage
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class ReadBusinessMessage implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private int $chatId,
        private int $messageId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'readBusinessMessage';
    }

    public function getData(): array
    {
        return [
            'business_connection_id' => $this->businessConnectionId,
            'chat_id' => $this->chatId,
            'message_id' => $this->messageId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
