<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardRemove;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ReplyKeyboardRemoveTest extends TestCase
{
    public function testBase(): void
    {
        $replyKeyboardRemove = new ReplyKeyboardRemove();

        assertNull($replyKeyboardRemove->selective);

        assertSame(
            [
                'remove_keyboard' => true,
            ],
            $replyKeyboardRemove->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $replyKeyboardRemove = new ReplyKeyboardRemove(true);

        assertTrue($replyKeyboardRemove->selective);

        assertSame(
            [
                'remove_keyboard' => true,
                'selective' => true,
            ],
            $replyKeyboardRemove->toRequestArray(),
        );
    }
}
