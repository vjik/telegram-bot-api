<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payments;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Payments\ShippingAddress;
use Vjik\TelegramBot\Api\Type\Payments\ShippingQuery;
use Vjik\TelegramBot\Api\Type\User;

final class ShippingQueryTest extends TestCase
{
    public function testShippingQuery(): void
    {
        $user = new User(1, false, 'Vjik');
        $shippingAddress = new ShippingAddress(
            'country_code',
            'state',
            'city',
            'street_line1',
            'street_line2',
            'post_code'
        );
        $shippingQuery = new ShippingQuery(
            'id',
            $user,
            'p12',
            $shippingAddress
        );

        $this->assertSame('id', $shippingQuery->id);
        $this->assertSame($user, $shippingQuery->from);
        $this->assertSame('p12', $shippingQuery->invoicePayload);
        $this->assertSame($shippingAddress, $shippingQuery->shippingAddress);
    }

    public function testFromTelegramResult(): void
    {
        $shippingQuery = ShippingQuery::fromTelegramResult([
            'id' => 'id',
            'from' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Vjik',
            ],
            'invoice_payload' => 'pl23',
            'shipping_address' => [
                'country_code' => 'country_code',
                'state' => 'state',
                'city' => 'city',
                'street_line1' => 'street_line1',
                'street_line2' => 'street_line2',
                'post_code' => 'post_code',
            ],
        ]);

        $this->assertSame('id', $shippingQuery->id);

        $this->assertInstanceOf(User::class, $shippingQuery->from);
        $this->assertSame(1, $shippingQuery->from->id);

        $this->assertSame('pl23', $shippingQuery->invoicePayload);

        $this->assertSame('country_code', $shippingQuery->shippingAddress->countryCode);
        $this->assertSame('state', $shippingQuery->shippingAddress->state);
        $this->assertSame('city', $shippingQuery->shippingAddress->city);
        $this->assertSame('street_line1', $shippingQuery->shippingAddress->streetLine1);
        $this->assertSame('street_line2', $shippingQuery->shippingAddress->streetLine2);
        $this->assertSame('post_code', $shippingQuery->shippingAddress->postCode);
    }
}
