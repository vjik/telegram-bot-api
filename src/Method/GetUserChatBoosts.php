<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\UserChatBoosts;

/**
 * @see https://core.telegram.org/bots/api#getuserchatboosts
 *
 * @template-implements MethodInterface<class-string<UserChatBoosts>>
 */
final readonly class GetUserChatBoosts implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $userId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getUserChatBoosts';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'user_id' => $this->userId,
        ];
    }

    public function getResultType(): string
    {
        return UserChatBoosts::class;
    }
}
