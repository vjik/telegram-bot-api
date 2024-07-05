<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\GeneralForumTopicUnhidden;

final class GeneralForumTopicUnhiddenTest extends TestCase
{
    public function testBase(): void
    {
        new GeneralForumTopicUnhidden();
        $this->expectNotToPerformAssertions();
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, GeneralForumTopicUnhidden::class);
        $this->expectNotToPerformAssertions();
    }
}
