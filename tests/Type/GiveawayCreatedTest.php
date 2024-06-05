<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
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
        GiveawayCreated::fromTelegramResult([]);
        $this->expectNotToPerformAssertions();
    }
}
