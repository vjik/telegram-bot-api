<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#closeforumtopic
 */
final readonly class CloseForumTopic implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private int $messageThreadId,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'closeForumTopic';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'message_thread_id' => $this->messageThreadId,
        ];
    }

    public function prepareResult(mixed $result): true
    {
        ValueHelper::assertTrueResult($result);
        return $result;
    }
}
