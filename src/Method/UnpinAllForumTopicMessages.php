<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#unpinallforumtopicmessages
 *
 * @template-implements MethodInterface<TrueValue>
 *
 * @api
 */
final readonly class UnpinAllForumTopicMessages implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $messageThreadId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'unpinAllForumTopicMessages';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'message_thread_id' => $this->messageThreadId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
