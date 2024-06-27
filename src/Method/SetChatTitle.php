<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#setchattitle
 */
final readonly class SetChatTitle implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private string $title,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setChatTitle';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'title' => $this->title,
        ];
    }

    public function prepareResult(mixed $result): true
    {
        return true;
    }
}
