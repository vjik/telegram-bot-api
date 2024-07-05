<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ChatBoostAdded;

final class ChatBoostAddedTest extends TestCase
{
    public function testBase(): void
    {
        $chatBoostAdded = new ChatBoostAdded(4);

        $this->assertSame(4, $chatBoostAdded->boostCount);
    }

    public function testFromTelegramResult(): void
    {
        $chatBoostAdded = (new ObjectFactory())->create([
            'boost_count' => 4,
        ], null, ChatBoostAdded::class);

        $this->assertSame(4, $chatBoostAdded->boostCount);
    }
}
