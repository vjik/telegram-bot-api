<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Payment\SendInvoice;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\Payment\LabeledPrice;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendInvoiceTest extends TestCase
{
    public function testBase(): void
    {
        $price = new LabeledPrice('The label', 100);
        $method = new SendInvoice(
            1,
            'The title',
            'The description',
            'The payload',
            'XTR',
            [$price]
        );

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendInvoice', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'title' => 'The title',
                'description' => 'The description',
                'payload' => 'The payload',
                'currency' => 'XTR',
                'prices' => [$price->toRequestArray()],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $price = new LabeledPrice('The label', 100);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $method = new SendInvoice(
            1,
            'The title',
            'The description',
            'The payload',
            'XTR',
            [$price],
            99,
            'The provider token',
            2,
            [3, 4],
            'The start',
            'The provider data',
            'https://example.com/photo.jpg',
            126687,
            100,
            120,
            true,
            false,
            false,
            true,
            true,
            true,
            false,
            false,
            true,
            'meid99',
            $replyParameters,
            $replyMarkup,
        );

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendInvoice', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'message_thread_id' => 99,
                'title' => 'The title',
                'description' => 'The description',
                'payload' => 'The payload',
                'provider_token' => 'The provider token',
                'currency' => 'XTR',
                'prices' => [$price->toRequestArray()],
                'max_tip_amount' => 2,
                'suggested_tip_amounts' => [3, 4],
                'start_parameter' => 'The start',
                'provider_data' => 'The provider data',
                'photo_url' => 'https://example.com/photo.jpg',
                'photo_size' => 126687,
                'photo_width' => 100,
                'photo_height' => 120,
                'need_name' => true,
                'need_phone_number' => false,
                'need_email' => false,
                'need_shipping_address' => true,
                'send_phone_number_to_provider' => true,
                'send_email_to_provider' => true,
                'is_flexible' => false,
                'disable_notification' => false,
                'protect_content' => true,
                'message_effect_id' => 'meid99',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendInvoice(
            1,
            'The title',
            'The description',
            'The payload',
            'XTR',
            []
        );

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
