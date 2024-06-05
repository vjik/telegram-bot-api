<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardRemove;

final class ReplyKeyboardRemoveTest extends TestCase
{
    public function testBase(): void
    {
        $replyKeyboardRemove = new ReplyKeyboardRemove();

        $this->assertNull($replyKeyboardRemove->selective);

        $this->assertSame(
            [
                'remove_keyboard' => true,
            ],
            $replyKeyboardRemove->toRequestArray()
        );
    }

    public function testFilled(): void
    {
        $replyKeyboardRemove = new ReplyKeyboardRemove(true);

        $this->assertTrue($replyKeyboardRemove->selective);

        $this->assertSame(
            [
                'remove_keyboard' => true,
                'selective' => true,
            ],
            $replyKeyboardRemove->toRequestArray()
        );
    }
}
