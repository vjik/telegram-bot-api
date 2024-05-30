<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Update;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;

/**
 * @see https://core.telegram.org/bots/api#setwebhook
 */
final readonly class SetWebhook implements TelegramRequestInterface
{
    public function __construct(
        private string $url,
        private ?string $ipAddress = null,
        private ?int $maxConnections = null,
        private ?array $allowUpdates = null,
        private ?bool $dropPendingUpdates = null,
        private ?string $secretToken = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setWebhook';
    }

    public function getData(): array
    {
        return array_filter([
            'url' => $this->url,
            'ip_address' => $this->ipAddress,
            'max_connections' => $this->maxConnections,
            'allowed_updates' => $this->allowUpdates,
            'drop_pending_updates' => $this->dropPendingUpdates,
            'secret_token' => $this->secretToken,
        ]);
    }
}
