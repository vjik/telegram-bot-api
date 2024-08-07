<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerUser;
use Vjik\TelegramBot\Api\Type\User;

final class TransactionPartnerUserTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'Mike');
        $object = new TransactionPartnerUser($user);

        $this->assertSame('user', $object->getType());
        $this->assertSame($user, $object->user);
        $this->assertNull($object->invoicePayload);
    }

    public function testFull(): void
    {
        $user = new User(123, false, 'Mike');
        $object = new TransactionPartnerUser($user, 'test');

        $this->assertSame('user', $object->getType());
        $this->assertSame($user, $object->user);
        $this->assertSame('test', $object->invoicePayload);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create([
            'type' => 'user',
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'Mike',
            ],
            'invoice_payload' => 'test',
        ], null, TransactionPartnerUser::class);

        $this->assertSame('user', $object->getType());
        $this->assertSame(123, $object->user->id);
        $this->assertSame('test', $object->invoicePayload);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, TransactionPartnerUser::class);
    }
}
