<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\StarAmount;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class StarAmountTest extends TestCase
{
    public function testBase(): void
    {
        $starAmount = new StarAmount(10);

        assertSame(10, $starAmount->amount);
        assertNull($starAmount->nanostarAmount);
    }

    public function testFromTelegramResult(): void
    {
        $starAmount = (new ObjectFactory())->create([
            'amount' => 10,
            'nanostar_amount' => 500000000,
        ], null, StarAmount::class);

        assertSame(10, $starAmount->amount);
        assertSame(500000000, $starAmount->nanostarAmount);
    }
}
