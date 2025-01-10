<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Type\ChatFullInfo;

/**
 * @see https://core.telegram.org/bots/api#getchat
 *
 * @template-implements TelegramRequestInterface<class-string<ChatFullInfo>>
 */
final readonly class GetChat implements TelegramRequestInterface
{
    public function __construct(
        private int|string $chatId,
    ) {}

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

    public function getResultType(): string
    {
        return ChatFullInfo::class;
    }
}
