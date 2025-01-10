<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#setchattitle
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<TrueValue>
 */
final readonly class SetChatTitle implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private string $title,
    ) {}

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

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
