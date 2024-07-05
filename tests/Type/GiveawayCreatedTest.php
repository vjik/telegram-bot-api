<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\GiveawayCreated;

final class GiveawayCreatedTest extends TestCase
{
    public function testBase(): void
    {
        new GiveawayCreated();
        $this->expectNotToPerformAssertions();
    }

    public function testFromTelegramResult(): void
    {
        (new ObjectFactory())->create([], null, GiveawayCreated::class);
        $this->expectNotToPerformAssertions();
    }
}
