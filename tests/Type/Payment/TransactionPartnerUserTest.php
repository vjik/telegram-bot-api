<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\PaidMediaPhoto;
use Vjik\TelegramBot\Api\Type\PaidMediaPreview;
use Vjik\TelegramBot\Api\Type\Payment\AffiliateInfo;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerUser;
use Vjik\TelegramBot\Api\Type\PhotoSize;
use Vjik\TelegramBot\Api\Type\User;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class TransactionPartnerUserTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'Mike');
        $object = new TransactionPartnerUser($user);

        assertSame('user', $object->getType());
        assertSame($user, $object->user);
        assertNull($object->invoicePayload);
        assertNull($object->paidMedia);
        assertNull($object->paidMediaPayload);
        assertNull($object->subscriptionPeriod);
        assertNull($object->gift);
        assertNull($object->affiliate);
    }

    public function testFull(): void
    {
        $user = new User(123, false, 'Mike');
        $paidMedia = [new PaidMediaPreview(), new PaidMediaPreview()];
        $affiliate = new AffiliateInfo(100, 200);
        $object = new TransactionPartnerUser(
            $user,
            'test',
            $paidMedia,
            'paid-payload',
            19,
            'The Gift',
            $affiliate,
        );

        assertSame('user', $object->getType());
        assertSame($user, $object->user);
        assertSame('test', $object->invoicePayload);
        assertSame($paidMedia, $object->paidMedia);
        assertSame('paid-payload', $object->paidMediaPayload);
        assertSame(19, $object->subscriptionPeriod);
        assertSame('The Gift', $object->gift);
        assertSame($affiliate, $object->affiliate);
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
                'affiliate' => [
                    'commission_per_mille' => 100,
                    'amount' => 200,
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

        assertSame('user', $object->getType());
        assertSame(123, $object->user->id);
        assertSame('test', $object->invoicePayload);
        assertEquals(
            [
                new PaidMediaPhoto([new PhotoSize('fid1', 'fuid1', 100, 200)]),
                new PaidMediaPreview(),
            ],
            $object->paidMedia,
        );
        assertSame('test-payload', $object->paidMediaPayload);
        assertSame(100, $object->affiliate->commissionPerMille);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, TransactionPartnerUser::class);
    }
}
