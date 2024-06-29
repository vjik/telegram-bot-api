<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Payment\LabeledPrice;

final class LabeledPriceTest extends TestCase
{
    public function testBase(): void
    {
        $type = new LabeledPrice('Red good', 10);

        $this->assertSame('Red good', $type->label);
        $this->assertSame(10, $type->amount);
        $this->assertSame(
            [
                'label' => 'Red good',
                'amount' => 10,
            ],
            $type->toRequestArray(),
        );
    }
}
