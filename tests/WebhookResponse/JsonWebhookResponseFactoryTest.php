<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\WebhookResponse;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendMessage;
use Vjik\TelegramBot\Api\WebhookResponse\JsonWebhookResponseFactory;
use Vjik\TelegramBot\Api\WebhookResponse\WebhookResponse;

use function PHPUnit\Framework\assertSame;

final class JsonWebhookResponseFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new JsonWebhookResponseFactory();
        $method = new SendMessage(chatId: 'x1', text: 'Hello');
        $webhookResponse = new WebhookResponse($method);

        $json = $factory->create($webhookResponse);

        assertSame('{"method":"sendMessage","chat_id":"x1","text":"Hello"}', $json);
    }

    public function testByMethod(): void
    {
        $factory = new JsonWebhookResponseFactory();
        $method = new SendMessage(chatId: 'x1', text: 'Hello');

        $json = $factory->byMethod($method);

        assertSame('{"method":"sendMessage","chat_id":"x1","text":"Hello"}', $json);
    }
}
