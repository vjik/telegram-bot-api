<?php

declare(strict_types=1);

namespace Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Payment\AffiliateInfo;

final class AffiliateInfoTest extends TestCase
{
    public function testBase(): void
    {
        $type = new AffiliateInfo(100, 200);

        $this->assertSame(100, $type->commissionPerMille);
        $this->assertSame(200, $type->amount);
        $this->assertNull($type->nanostarAmount);
        $this->assertNull($type->affiliateUser);
        $this->assertNull($type->affiliateChat);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'affiliate_user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'Mike',
            ],
            'affiliate_chat' => [
                'id' => 456,
                'type' => 'private',
            ],
            'commission_per_mille' => 100,
            'amount' => 200,
            'nanostar_amount' => 300,
        ], null, AffiliateInfo::class);

        $this->assertSame(100, $type->commissionPerMille);
        $this->assertSame(200, $type->amount);
        $this->assertSame(300, $type->nanostarAmount);
        $this->assertSame(123, $type->affiliateUser->id);
        $this->assertSame(456, $type->affiliateChat->id);
    }
}
