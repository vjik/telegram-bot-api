<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InputInvoiceMessageContent;
use Vjik\TelegramBot\Api\Type\Payment\LabeledPrice;

final class InputInvoiceMessageContentTest extends TestCase
{
    public function testBase(): void
    {
        $price = new LabeledPrice('label', 10);
        $type = new InputInvoiceMessageContent(
            'Title',
            'Description',
            'Payload',
            'XTR',
            [$price],
        );

        $this->assertSame('Title', $type->title);
        $this->assertSame('Description', $type->description);
        $this->assertSame('Payload', $type->payload);
        $this->assertSame('XTR', $type->currency);
        $this->assertSame([$price], $type->prices);
        $this->assertNull($type->providerToken);
        $this->assertNull($type->maxTipAmount);
        $this->assertNull($type->suggestedTipAmounts);
        $this->assertNull($type->providerData);
        $this->assertNull($type->photoUrl);
        $this->assertNull($type->photoSize);
        $this->assertNull($type->photoWidth);
        $this->assertNull($type->photoHeight);
        $this->assertNull($type->needName);
        $this->assertNull($type->needPhoneNumber);
        $this->assertNull($type->needEmail);
        $this->assertNull($type->needShippingAddress);
        $this->assertNull($type->sendPhoneNumberToProvider);
        $this->assertNull($type->sendEmailToProvider);
        $this->assertNull($type->isFlexible);

        $this->assertSame(
            [
                'title' => 'Title',
                'description' => 'Description',
                'payload' => 'Payload',
                'currency' => 'XTR',
                'prices' => [$price->toRequestArray()],
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $price = new LabeledPrice('label', 10);
        $type = new InputInvoiceMessageContent(
            'Title',
            'Description',
            'Payload',
            'XTR',
            [$price],
            'ProviderToken',
            100,
            [10, 20, 30],
            'ProviderData',
            'https://example.com/photo.png',
            205654,
            1024,
            768,
            true,
            false,
            true,
            true,
            true,
            true,
            false,
        );

        $this->assertSame('Title', $type->title);
        $this->assertSame('Description', $type->description);
        $this->assertSame('Payload', $type->payload);
        $this->assertSame('XTR', $type->currency);
        $this->assertSame([$price], $type->prices);
        $this->assertSame('ProviderToken', $type->providerToken);
        $this->assertSame(100, $type->maxTipAmount);
        $this->assertSame([10, 20, 30], $type->suggestedTipAmounts);
        $this->assertSame('ProviderData', $type->providerData);
        $this->assertSame('https://example.com/photo.png', $type->photoUrl);
        $this->assertSame(205654, $type->photoSize);
        $this->assertSame(1024, $type->photoWidth);
        $this->assertSame(768, $type->photoHeight);
        $this->assertTrue($type->needName);
        $this->assertFalse($type->needPhoneNumber);
        $this->assertTrue($type->needEmail);
        $this->assertTrue($type->needShippingAddress);
        $this->assertTrue($type->sendPhoneNumberToProvider);
        $this->assertTrue($type->sendEmailToProvider);
        $this->assertFalse($type->isFlexible);

        $this->assertSame(
            [
                'title' => 'Title',
                'description' => 'Description',
                'payload' => 'Payload',
                'provider_token' => 'ProviderToken',
                'currency' => 'XTR',
                'prices' => [$price->toRequestArray()],
                'max_tip_amount' => 100,
                'suggested_tip_amounts' => [10, 20, 30],
                'provider_data' => 'ProviderData',
                'photo_url' => 'https://example.com/photo.png',
                'photo_size' => 205654,
                'photo_width' => 1024,
                'photo_height' => 768,
                'need_name' => true,
                'need_phone_number' => false,
                'need_email' => true,
                'need_shipping_address' => true,
                'send_phone_number_to_provider' => true,
                'send_email_to_provider' => true,
                'is_flexible' => false,
            ],
            $type->toRequestArray(),
        );
    }
}
