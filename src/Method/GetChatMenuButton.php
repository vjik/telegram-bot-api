<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\MenuButtonValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#getchatmenubutton
 */
final readonly class GetChatMenuButton implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private ?int $chatId = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getChatMenuButton';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): MenuButtonValue
    {
        return new MenuButtonValue();
    }
}
