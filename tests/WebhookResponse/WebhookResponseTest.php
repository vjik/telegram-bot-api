<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\WebhookResponse;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendMessage;
use Vjik\TelegramBot\Api\Method\SendPhoto;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\WebhookResponse\MethodNotSupportedException;
use Vjik\TelegramBot\Api\WebhookResponse\WebhookResponse;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;
use function PHPUnit\Framework\assertFalse;

final class WebhookResponseTest extends TestCase
{
    public function testSimpleMethodWithoutData(): void
    {
        $method = new SendMessage(chatId: 'x1', text: 'Hello');
        $webhookResponse = new WebhookResponse($method);

        $data = $webhookResponse->getData();

        assertTrue($webhookResponse->isSupported());
        assertSame(
            [
                'method' => 'sendMessage',
                'chat_id' => 'x1',
                'text' => 'Hello',
            ],
            $data,
        );
    }

    public function testMethodWithInputFile(): void
    {
        $method = new SendPhoto(
            chatId: 'x1',
            photo: new InputFile((new StreamFactory())->createStream()),
        );

        $webhookResponse = new WebhookResponse($method);

        assertFalse($webhookResponse->isSupported());

        $this->expectException(MethodNotSupportedException::class);
        $this->expectExceptionMessage('InputFile is not supported in Webhook response.');
        $webhookResponse->getData();
    }
}
