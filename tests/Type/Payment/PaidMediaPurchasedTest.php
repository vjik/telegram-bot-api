<?php

declare(strict_types=1);

namespace Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Payment\PaidMediaPurchased;
use Vjik\TelegramBot\Api\Type\User;

final class PaidMediaPurchasedTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'Vjik');
        $object = new PaidMediaPurchased($user, 'payload');

        $this->assertSame($user, $object->from);
        $this->assertSame('payload', $object->payload);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create(
            [
                'from' => [
                    'id' => 1,
                    'is_bot' => false,
                    'first_name' => 'Vjik',
                ],
                'payload' => 'test',
            ],
            null,
            PaidMediaPurchased::class,
        );

        $this->assertInstanceOf(User::class, $object->from);
        $this->assertSame(1, $object->from->id);

        $this->assertSame('test', $object->payload);
    }
}
