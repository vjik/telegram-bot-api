<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ReactionTypePaid;

use function PHPUnit\Framework\assertSame;

final class ReactionTypePaidTest extends TestCase
{
    public function testBase(): void
    {
        $reaction = new ReactionTypePaid();

        assertSame('paid', $reaction->getType());
        assertSame(
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

        assertSame('paid', $reaction->getType());
    }
}
