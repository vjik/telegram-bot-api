<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Update;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#deletewebhook
 */
final readonly class DeleteWebhook implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private ?bool $dropPendingUpdates = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteWebhook';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'drop_pending_updates' => $this->dropPendingUpdates,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function prepareResult(mixed $result): true
    {
        return true;
    }
}
