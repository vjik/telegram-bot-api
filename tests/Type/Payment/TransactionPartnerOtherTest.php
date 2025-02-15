<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerOther;

use function PHPUnit\Framework\assertSame;

final class TransactionPartnerOtherTest extends TestCase
{
    public function testBase(): void
    {
        $object = new TransactionPartnerOther();

        assertSame('other', $object->getType());
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create([
            'type' => 'other',
        ], null, TransactionPartnerOther::class);

        assertSame('other', $object->getType());
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, TransactionPartnerOther::class);
    }
}
