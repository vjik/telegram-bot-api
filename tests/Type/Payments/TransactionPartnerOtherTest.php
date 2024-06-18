<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payments;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Payments\TransactionPartnerOther;

final class TransactionPartnerOtherTest extends TestCase
{
    public function testBase(): void
    {
        $object = new TransactionPartnerOther();

        $this->assertSame('other', $object->getType());
    }

    public function testFromTelegramResult(): void
    {
        $object = TransactionPartnerOther::fromTelegramResult([
            'type' => 'other',
        ]);

        $this->assertSame('other', $object->getType());
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as array. Got "string".');
        TransactionPartnerOther::fromTelegramResult('hello');
    }
}
