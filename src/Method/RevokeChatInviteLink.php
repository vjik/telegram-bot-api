<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\ChatInviteLink;

/**
 * @see https://core.telegram.org/bots/api#revokechatinvitelink
 *
 * @template-implements MethodInterface<ChatInviteLink>
 */
final readonly class RevokeChatInviteLink implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private string $inviteLink,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'revokeChatInviteLink';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'invite_link' => $this->inviteLink,
        ];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(ChatInviteLink::class);
    }
}
