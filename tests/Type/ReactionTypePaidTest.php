<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ReactionTypePaid;

final class ReactionTypePaidTest extends TestCase
{
    public function testBase(): void
    {
        $reaction = new ReactionTypePaid();

        $this->assertSame('paid', $reaction->getType());
        $this->assertSame(
            [
                'type' => 'paid',
            ],
            $reaction->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $reaction = (new ObjectFactory())->create(
            [
                'type' => 'paid',
            ],
            null,
            ReactionTypePaid::class,
        );

        $this->assertSame('paid', $reaction->getType());
    }
}
