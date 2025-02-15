<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\VideoChatScheduled;

use function PHPUnit\Framework\assertSame;

final class VideoChatScheduledTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $videoChatScheduled = new VideoChatScheduled($date);

        assertSame($date, $videoChatScheduled->startDate);
    }

    public function testFromTelegramResult(): void
    {
        $videoChatScheduled = (new ObjectFactory())->create([
            'start_date' => 1234567890,
        ], null, VideoChatScheduled::class);

        assertSame(1234567890, $videoChatScheduled->startDate->getTimestamp());
    }
}
