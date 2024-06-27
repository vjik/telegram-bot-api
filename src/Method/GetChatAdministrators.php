<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\ChatMember;
use Vjik\TelegramBot\Api\Type\ChatMemberFactory;

/**
 * @see https://core.telegram.org/bots/api#getchatadministrators
 */
final readonly class GetChatAdministrators implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getChatAdministrators';
    }

    public function getData(): array
    {
        return ['chat_id' => $this->chatId];
    }

    /**
     * @return ChatMember[]
     */
    public function prepareResult(mixed $result): array
    {
        ValueHelper::assertArrayResult($result);
        return array_map(
            static fn(mixed $item) => ChatMemberFactory::fromTelegramResult($item),
            $result
        );
    }
}
