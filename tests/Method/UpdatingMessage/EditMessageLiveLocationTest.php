<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\EditMessageLiveLocation;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\Message;

final class EditMessageLiveLocationTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditMessageLiveLocation(51.660781, 39.200296);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('editMessageLiveLocation', $method->getApiMethod());
        $this->assertSame(
            [
                'latitude' => 51.660781,
                'longitude' => 39.200296,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('hello')]]);
        $method = new EditMessageLiveLocation(
            51.660781,
            39.200296,
            'bcid1',
            23,
            34,
            'imid',
            1000,
            20.5,
            220,
            500,
            $replyMarkup,
        );

        $this->assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 23,
                'message_id' => 34,
                'inline_message_id' => 'imid',
                'latitude' => 51.660781,
                'longitude' => 39.200296,
                'live_period' => 1000,
                'horizontal_accuracy' => 20.5,
                'heading' => 220,
                'proximity_alert_radius' => 500,
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData()
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditMessageLiveLocation(51.660781, 39.200296);

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);
        $this->assertTrue($preparedResult);

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->send($method);
        $this->assertInstanceOf(Message::class, $preparedResult);
        $this->assertSame(7, $preparedResult->messageId);
    }
}
