<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use DateTimeInterface;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#banchatmember
 */
final readonly class BanChatMember implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private int $userId,
        private ?DateTimeInterface $untilDate = null,
        private ?bool $revokeMessages = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'banChatMember';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'user_id' => $this->userId,
                'until_date' => $this->untilDate?->getTimestamp(),
                'revoke_messages' => $this->revokeMessages,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
