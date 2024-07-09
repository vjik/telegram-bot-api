<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\ChatInviteLink;

/**
 * @see https://core.telegram.org/bots/api#editchatinvitelink
 */
final readonly class EditChatInviteLink implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private string $inviteLink,
        private ?string $name = null,
        private ?DateTimeImmutable $expireDate = null,
        private ?int $memberLimit = null,
        private ?bool $createsJoinRequest = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'editChatInviteLink';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'invite_link' => $this->inviteLink,
                'name' => $this->name,
                'expire_date' => $this->expireDate?->getTimestamp(),
                'member_limit' => $this->memberLimit,
                'creates_join_request' => $this->createsJoinRequest,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): string
    {
        return ChatInviteLink::class;
    }
}
