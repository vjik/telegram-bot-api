<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;

/**
 * @see https://core.telegram.org/bots/api#getchat
 */
final readonly class GetChat implements TelegramRequestInterface
{
    public function __construct(
        private int|string $chatId,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getChat';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
        ];
    }

    public function getSuccessCallback(): ?callable
    {
        return null;
//        return static fn(mixed $result) => ChatF::fromTelegramResult($result);
    }
}
