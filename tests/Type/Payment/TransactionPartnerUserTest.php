<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
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
    }

    public function testFromTelegramResult(): void
    {
        $object = TransactionPartnerUser::fromTelegramResult([
            'type' => 'user',
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'Mike',
            ],
        ]);

        $this->assertSame('user', $object->getType());
        $this->assertSame(123, $object->user->id);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as array. Got "string".');
        TransactionPartnerUser::fromTelegramResult('hello');
    }
}
