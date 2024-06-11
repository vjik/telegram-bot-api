<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendContact;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendContactTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendContact(12, '1234567890', 'John');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendContact', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'phone_number' => '1234567890',
                'first_name' => 'John',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendContact(
            12,
            '1234567890',
            'John',
            'bcid1',
            99,
            'Doe',
            'vcard1',
            true,
            false,
            'meid1',
            $replyParameters,
            $replyMarkup,
        );

        $this->assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'phone_number' => '1234567890',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'vcard' => 'vcard1',
                'disable_notification' => true,
                'protect_content' => false,
                'message_effect_id' => 'meid1',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendContact(12, '1234567890', 'John');

        $preparedResult = $method->prepareResult([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $this->assertSame(7, $preparedResult->messageId);
    }
}
