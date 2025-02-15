<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\MessageAutoDeleteTimerChanged;

use function PHPUnit\Framework\assertSame;

final class MessageAutoDeleteTimerChangedTest extends TestCase
{
    public function testBase(): void
    {
        $messageAutoDeleteTimerChanged = new MessageAutoDeleteTimerChanged(12);

        assertSame(12, $messageAutoDeleteTimerChanged->messageAutoDeleteTime);
    }

    public function testFromTelegramResult(): void
    {
        $messageAutoDeleteTimerChanged = (new ObjectFactory())->create([
            'message_auto_delete_time' => 12,
        ], null, MessageAutoDeleteTimerChanged::class);

        assertSame(12, $messageAutoDeleteTimerChanged->messageAutoDeleteTime);
    }
}
