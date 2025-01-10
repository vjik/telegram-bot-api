<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\ChatInviteLink;

/**
 * @see https://core.telegram.org/bots/api#editchatsubscriptioninvitelink
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<class-string<ChatInviteLink>>
 */
final readonly class EditChatSubscriptionInviteLink implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private string $inviteLink,
        private ?string $name = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'editChatSubscriptionInviteLink';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'invite_link' => $this->inviteLink,
                'name' => $this->name,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): string
    {
        return ChatInviteLink::class;
    }
}
