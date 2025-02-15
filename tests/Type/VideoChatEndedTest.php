<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\VideoChatEnded;

use function PHPUnit\Framework\assertSame;

final class VideoChatEndedTest extends TestCase
{
    public function testBase(): void
    {
        $videoChatEnded = new VideoChatEnded(12);

        assertSame(12, $videoChatEnded->duration);
    }

    public function testFromTelegramResult(): void
    {
        $videoChatEnded = (new ObjectFactory())->create([
            'duration' => 12,
        ], null, VideoChatEnded::class);

        assertSame(12, $videoChatEnded->duration);
    }
}
