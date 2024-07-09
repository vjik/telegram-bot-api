<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendVenue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendVenueTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendVenue(12, 1.1, 2.2, 'Moscow', 'Kremlin');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendVenue', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'latitude' => 1.1,
                'longitude' => 2.2,
                'title' => 'Moscow',
                'address' => 'Kremlin',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendVenue(
            12,
            1.1,
            2.2,
            'Moscow',
            'Kremlin',
            'bcid1',
            99,
            'fs1',
            'ft2',
            'gp1',
            'gt2',
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
                'latitude' => 1.1,
                'longitude' => 2.2,
                'title' => 'Moscow',
                'address' => 'Kremlin',
                'foursquare_id' => 'fs1',
                'foursquare_type' => 'ft2',
                'google_place_id' => 'gp1',
                'google_place_type' => 'gt2',
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
        $method = new SendVenue(12, 1.1, 2.2, 'Moscow', 'Kremlin');

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->send($method);

        $this->assertSame(7, $preparedResult->messageId);
    }
}
