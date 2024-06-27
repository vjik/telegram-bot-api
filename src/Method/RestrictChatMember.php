<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\ChatPermissions;

/**
 * @see https://core.telegram.org/bots/api#restrictchatmember
 */
final readonly class RestrictChatMember implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private int $userId,
        private ChatPermissions $permissions,
        private ?bool $useIndependentChatPermissions = null,
        private ?DateTimeImmutable $untilDate = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'restrictChatMember';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'user_id' => $this->userId,
                'permissions' => $this->permissions->toRequestArray(),
                'use_independent_chat_permissions' => $this->useIndependentChatPermissions,
                'until_date' => $this->untilDate?->getTimestamp(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function prepareResult(mixed $result): true
    {
        ValueHelper::assertTrueResult($result);
        return $result;
    }
}
