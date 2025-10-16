<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\WebhookResponse;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Vjik\TelegramBot\Api\MethodInterface;

use function json_encode;

/**
 * @api
 */
final readonly class PsrWebhookResponseFactory
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private StreamFactoryInterface $streamFactory,
    ) {}

    /**
     * @throws MethodNotSupportedException If method doesn't support sending via a webhook response.
     */
    public function byMethod(MethodInterface $method): ResponseInterface
    {
        return $this->byWebhookResponse(new WebhookResponse($method));
    }

    /**
     * @throws MethodNotSupportedException If method doesn't support sending via a webhook response.
     */
    public function byWebhookResponse(WebhookResponse $webhookResponse): ResponseInterface
    {
        $body = $this->streamFactory->createStream(
            json_encode($webhookResponse->getData(), JSON_THROW_ON_ERROR),
        );

        return $this->responseFactory
            ->createResponse()
            ->withBody($body)
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withHeader('Content-Length', (string) $body->getSize());
    }
}
