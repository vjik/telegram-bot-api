<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#declinesuggestedpost
 *
 * @template-implements MethodInterface<true>
 */
final readonly class DeclineSuggestedPost implements MethodInterface
{
    public function __construct(
        private int $chatId,
        private int $messageId,
        private ?string $comment = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'declineSuggestedPost';
    }

    public function getData(): array
    {
        $data = [
            'chat_id' => $this->chatId,
            'message_id' => $this->messageId,
        ];

        if ($this->comment !== null) {
            $data['comment'] = $this->comment;
        }

        return $data;
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
