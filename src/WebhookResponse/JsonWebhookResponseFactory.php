<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\WebhookResponse;

use Vjik\TelegramBot\Api\MethodInterface;

/**
 * @api
 */
final readonly class JsonWebhookResponseFactory
{
    /**
     * @throws MethodNotSupportedException If method doesn't support sending via a webhook response.
     */
    public function byMethod(MethodInterface $method): string
    {
        return $this->byWebhookResponse(new WebhookResponse($method));
    }

    /**
     * @throws MethodNotSupportedException If method doesn't support sending via a webhook response.
     */
    public function byWebhookResponse(WebhookResponse $webhookResponse): string
    {
        return json_encode($webhookResponse->getData(), JSON_THROW_ON_ERROR);
    }
}
