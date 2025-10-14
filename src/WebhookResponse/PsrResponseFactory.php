<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\WebhookResponse;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Vjik\TelegramBot\Api\MethodInterface;

/**
 * @api
 */
final readonly class PsrResponseFactory
{
    private JsonResponseFactory $jsonWebhookResponse;

    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private StreamFactoryInterface $streamFactory,
    ) {
        $this->jsonWebhookResponse = new JsonResponseFactory();
    }

    public function create(MethodInterface $method): ResponseInterface
    {
        $body = $this->streamFactory->createStream(
            $this->jsonWebhookResponse->create($method),
        );

        return $this->responseFactory
            ->createResponse()
            ->withBody($body)
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withHeader('Content-Length', (string) $body->getSize());
    }
}
