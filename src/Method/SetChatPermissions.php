<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\ChatPermissions;

/**
 * @see https://core.telegram.org/bots/api#setchatpermissions
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<TrueValue>
 */
final readonly class SetChatPermissions implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private ChatPermissions $permissions,
        private ?bool $useIndependentChatPermissions = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setChatPermissions';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'permissions' => $this->permissions->toRequestArray(),
                'use_independent_chat_permissions' => $this->useIndependentChatPermissions,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
