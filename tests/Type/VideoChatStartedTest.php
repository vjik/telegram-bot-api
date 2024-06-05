<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\VideoChatStarted;

final class VideoChatStartedTest extends TestCase
{
    public function testBase(): void
    {
        new VideoChatStarted();
        $this->expectNotToPerformAssertions();
    }

    public function testFromTelegramResult(): void
    {
        VideoChatStarted::fromTelegramResult([]);
        $this->expectNotToPerformAssertions();
    }
}
