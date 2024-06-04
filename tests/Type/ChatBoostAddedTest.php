<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
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
        $chatBoostAdded = ChatBoostAdded::fromTelegramResult([
            'boost_count' => 4,
        ]);

        $this->assertSame(4, $chatBoostAdded->boostCount);
    }
}
