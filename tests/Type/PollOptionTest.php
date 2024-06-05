<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\PollOption;

final class PollOptionTest extends TestCase
{
    public function testBase(): void
    {
        $option = new PollOption('A', 25);

        $this->assertSame('A', $option->text);
        $this->assertSame(25, $option->voterCount);
        $this->assertNull($option->textEntities);
    }

    public function testFromTelegramResult(): void
    {
        $option = PollOption::fromTelegramResult([
            'text' => 'A',
            'voter_count' => 25,
            'text_entities' => [
                [
                    'offset' => 23,
                    'length' => 1,
                    'type' => 'bold',
                ],
            ],
        ]);

        $this->assertSame('A', $option->text);
        $this->assertSame(25, $option->voterCount);

        $this->assertCount(1, $option->textEntities);
        $this->assertSame(23, $option->textEntities[0]->offset);
    }
}
