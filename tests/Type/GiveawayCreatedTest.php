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
        $object = new GiveawayCreated();

        $this->assertNull($object->prizeStarCount);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create(
            [
                'prize_star_count' => 23,
            ],
            null,
            GiveawayCreated::class,
        );

        $this->assertSame(23, $object->prizeStarCount);
    }
}
