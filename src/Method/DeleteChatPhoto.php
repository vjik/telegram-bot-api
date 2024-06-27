<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#deletechatphoto
 */
final readonly class DeleteChatPhoto implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteChatPhoto';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
        ];
    }

    public function prepareResult(mixed $result): true
    {
        return true;
    }
}
