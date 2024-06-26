<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#approvechatjoinrequest
 */
final readonly class ApproveChatJoinRequest implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private int $userId,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'approveChatJoinRequest';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'user_id' => $this->userId,
        ];
    }

    public function prepareResult(mixed $result): true
    {
        return true;
    }
}
