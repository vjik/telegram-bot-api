<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ForumTopicClosed;

final class ForumTopicClosedTest extends TestCase
{
    public function testBase(): void
    {
        new ForumTopicClosed();
        $this->expectNotToPerformAssertions();
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, ForumTopicClosed::class);
        $this->expectNotToPerformAssertions();
    }
}
