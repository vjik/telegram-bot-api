<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendContact;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

use function PHPUnit\Framework\assertSame;

final class SendContactTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendContact(12, '1234567890', 'John');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendContact', $method->getApiMethod());
        assertSame(
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
            true,
        );

        assertSame(
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
                'allow_paid_broadcast' => true,
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

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->call($method);

        assertSame(7, $preparedResult->messageId);
    }
}
