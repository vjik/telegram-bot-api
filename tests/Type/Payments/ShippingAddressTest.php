<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payments;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Payments\ShippingAddress;

final class ShippingAddressTest extends TestCase
{
    public function testBase(): void
    {
        $shippingAddress = new ShippingAddress('ru', 'the-state', 'the-city', 'the-street1', 'the-street2', '111');

        $this->assertSame('ru', $shippingAddress->countryCode);
        $this->assertSame('the-state', $shippingAddress->state);
        $this->assertSame('the-city', $shippingAddress->city);
        $this->assertSame('the-street1', $shippingAddress->streetLine1);
        $this->assertSame('the-street2', $shippingAddress->streetLine2);
        $this->assertSame('111', $shippingAddress->postCode);
    }

    public function testFromTelegramResult(): void
    {
        $shippingAddress = ShippingAddress::fromTelegramResult([
            'country_code' => 'ru',
            'state' => 'state',
            'city' => 'city',
            'street_line1' => 'street1',
            'street_line2' => 'street2',
            'post_code' => '213',
        ]);

        $this->assertSame('ru', $shippingAddress->countryCode);
        $this->assertSame('state', $shippingAddress->state);
        $this->assertSame('city', $shippingAddress->city);
        $this->assertSame('street1', $shippingAddress->streetLine1);
        $this->assertSame('street2', $shippingAddress->streetLine2);
        $this->assertSame('213', $shippingAddress->postCode);
    }
}
