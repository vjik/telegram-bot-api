<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\ChatInviteLink;

/**
 * @see https://core.telegram.org/bots/api#createchatsubscriptioninvitelink
 */
final readonly class CreateChatSubscriptionInviteLink implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private int $subscriptionPeriod,
        private int $subscriptionPrice,
        private ?string $name = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'createChatSubscriptionInviteLink';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'name' => $this->name,
                'subscription_period' => $this->subscriptionPeriod,
                'subscription_price' => $this->subscriptionPrice,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): string
    {
        return ChatInviteLink::class;
    }
}
