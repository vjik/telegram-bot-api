<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#approvesuggestedpost
 *
 * @template-implements MethodInterface<true>
 */
final readonly class ApproveSuggestedPost implements MethodInterface
{
    public function __construct(
        private int $chatId,
        private int $messageId,
        private ?int $sendDate = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'approveSuggestedPost';
    }

    public function getData(): array
    {
        $data = [
            'chat_id' => $this->chatId,
            'message_id' => $this->messageId,
        ];

        if ($this->sendDate !== null) {
            $data['send_date'] = $this->sendDate;
        }

        return $data;
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
