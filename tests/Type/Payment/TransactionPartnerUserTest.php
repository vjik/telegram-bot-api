<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\PaidMediaPhoto;
use Vjik\TelegramBot\Api\Type\PaidMediaPreview;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerUser;
use Vjik\TelegramBot\Api\Type\PhotoSize;
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
        $this->assertNull($object->paidMedia);
        $this->assertNull($object->paidMediaPayload);
        $this->assertNull($object->subscriptionPeriod);
        $this->assertNull($object->gift);
    }

    public function testFull(): void
    {
        $user = new User(123, false, 'Mike');
        $paidMedia = [new PaidMediaPreview(), new PaidMediaPreview()];
        $object = new TransactionPartnerUser(
            $user,
            'test',
            $paidMedia,
            'paid-payload',
            19,
            'The Gift',
        );

        $this->assertSame('user', $object->getType());
        $this->assertSame($user, $object->user);
        $this->assertSame('test', $object->invoicePayload);
        $this->assertSame($paidMedia, $object->paidMedia);
        $this->assertSame('paid-payload', $object->paidMediaPayload);
        $this->assertSame(19, $object->subscriptionPeriod);
        $this->assertSame('The Gift', $object->gift);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create(
            [
                'type' => 'user',
                'user' => [
                    'id' => 123,
                    'is_bot' => false,
                    'first_name' => 'Mike',
                ],
                'invoice_payload' => 'test',
                'paid_media' => [
                    [
                        'type' => 'photo',
                        'photo' => [
                            [
                                'file_id' => 'fid1',
                                'file_unique_id' => 'fuid1',
                                'width' => 100,
                                'height' => 200,
                            ],
                        ],
                    ],
                    [
                        'type' => 'preview',

                    ],
                ],
                'paid_media_payload' => 'test-payload',
            ],
            null,
            TransactionPartnerUser::class,
        );

        $this->assertSame('user', $object->getType());
        $this->assertSame(123, $object->user->id);
        $this->assertSame('test', $object->invoicePayload);
        $this->assertEquals(
            [
                new PaidMediaPhoto([new PhotoSize('fid1', 'fuid1', 100, 200)]),
                new PaidMediaPreview(),
            ],
            $object->paidMedia,
        );
        $this->assertSame('test-payload', $object->paidMediaPayload);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, TransactionPartnerUser::class);
    }
}
