<?php

declare(strict_types=1);

namespace Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerAffiliateProgram;
use Vjik\TelegramBot\Api\Type\User;

final class TransactionPartnerAffiliateProgramTest extends TestCase
{
    public function testBase(): void
    {
        $object = new TransactionPartnerAffiliateProgram(200);

        $this->assertSame('affiliate_program', $object->getType());
        $this->assertSame(200, $object->commissionPerMille);
        $this->assertNull($object->sponsorUser);
    }

    public function testFull(): void
    {
        $user = new User(123, false, 'Mike');
        $object = new TransactionPartnerAffiliateProgram(
            200,
            $user,
        );

        $this->assertSame('affiliate_program', $object->getType());
        $this->assertSame(200, $object->commissionPerMille);
        $this->assertSame($user, $object->sponsorUser);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create(
            [
                'type' => 'affiliate_program',
                'sponsor_user' => [
                    'id' => 123,
                    'is_bot' => false,
                    'first_name' => 'Mike',
                ],
                'commission_per_mille' => 203,
            ],
            null,
            TransactionPartnerAffiliateProgram::class,
        );

        $this->assertSame('affiliate_program', $object->getType());
        $this->assertSame(203, $object->commissionPerMille);
        $this->assertSame(123, $object->sponsorUser->id);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, TransactionPartnerAffiliateProgram::class);
    }
}
