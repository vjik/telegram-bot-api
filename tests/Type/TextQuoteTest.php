<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\TextQuote;

final class TextQuoteTest extends TestCase
{
    public function testBase(): void
    {
        $textQuote = new TextQuote('test', 23);

        $this->assertSame('test', $textQuote->text);
        $this->assertSame(23, $textQuote->position);
        $this->assertNull($textQuote->entities);
        $this->assertNull($textQuote->isManual);
    }

    public function testFromTelegramResult(): void
    {
        $textQuote = (new ObjectFactory())->create([
            'text' => 'test',
            'position' => 23,
            'entities' => [
                [
                    'offset' => 0,
                    'length' => 4,
                    'type' => 'bold',
                ],
            ],
            'is_manual' => true,
        ], null, TextQuote::class);

        $this->assertSame('test', $textQuote->text);
        $this->assertSame(23, $textQuote->position);

        $this->assertCount(1, $textQuote->entities);
        $this->assertSame('bold', $textQuote->entities[0]->type);
        $this->assertSame(0, $textQuote->entities[0]->offset);
        $this->assertSame(4, $textQuote->entities[0]->length);

        $this->assertTrue($textQuote->isManual);
    }
}
