<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ForumTopicReopened;

final class ForumTopicReopenedTest extends TestCase
{
    public function testBase(): void
    {
        new ForumTopicReopened();
        $this->expectNotToPerformAssertions();
    }

    public function testFromTelegramResult(): void
    {
        ForumTopicReopened::fromTelegramResult([]);
        $this->expectNotToPerformAssertions();
    }
}
