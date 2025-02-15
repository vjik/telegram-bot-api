<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Payment\LabeledPrice;
use Vjik\TelegramBot\Api\Type\Payment\ShippingOption;

use function PHPUnit\Framework\assertSame;

final class ShippingOptionTest extends TestCase
{
    public function testBase(): void
    {
        $price = new LabeledPrice('label', 100);
        $type = new ShippingOption(
            'id',
            'title',
            [$price],
        );

        assertSame(
            [
                'id' => 'id',
                'title' => 'title',
                'prices' => [$price->toRequestArray()],
            ],
            $type->toRequestArray(),
        );
    }
}
