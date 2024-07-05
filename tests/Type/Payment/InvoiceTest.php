<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Payment\Invoice;

final class InvoiceTest extends TestCase
{
    public function testBase(): void
    {
        $invoice = new Invoice('product', 'desc', 'hi', 'RUB', 200);

        $this->assertSame('product', $invoice->title);
        $this->assertSame('desc', $invoice->description);
        $this->assertSame('hi', $invoice->startParameter);
        $this->assertSame('RUB', $invoice->currency);
        $this->assertSame(200, $invoice->totalAmount);
    }

    public function testFromTelegramResult(): void
    {
        $invoice = (new ObjectFactory())->create([
            'title' => 'product',
            'description' => 'desc',
            'start_parameter' => 'hi',
            'currency' => 'RUB',
            'total_amount' => 200,
        ], null, Invoice::class);

        $this->assertSame('product', $invoice->title);
        $this->assertSame('desc', $invoice->description);
        $this->assertSame('hi', $invoice->startParameter);
        $this->assertSame('RUB', $invoice->currency);
        $this->assertSame(200, $invoice->totalAmount);
    }
}
