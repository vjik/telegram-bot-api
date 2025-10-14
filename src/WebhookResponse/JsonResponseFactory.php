<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\WebhookResponse;

use Vjik\TelegramBot\Api\MethodInterface;

use function json_encode;

final readonly class JsonResponseFactory
{
    private ArrayResponseFactory $arrayWebhookResponse;

    public function __construct()
    {
        $this->arrayWebhookResponse = new ArrayResponseFactory();
    }

    public function create(MethodInterface $method): string
    {
        return json_encode(
            $this->arrayWebhookResponse->create($method),
            JSON_THROW_ON_ERROR,
        );
    }
}
