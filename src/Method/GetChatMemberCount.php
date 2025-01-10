<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\IntegerValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#getchatmembercount
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<IntegerValue>
 */
final readonly class GetChatMemberCount implements TelegramRequestWithResultPreparingInterface
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
        return 'getChatMemberCount';
    }

    public function getData(): array
    {
        return ['chat_id' => $this->chatId];
    }

    public function getResultType(): IntegerValue
    {
        return new IntegerValue();
    }
}
