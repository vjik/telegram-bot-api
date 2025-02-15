<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\BotShortDescription;

use function PHPUnit\Framework\assertSame;

final class BotShortDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $description = new BotShortDescription('test');

        assertSame('test', $description->shortDescription);
    }

    public function testFromTelegramResult(): void
    {
        $description = (new ObjectFactory())->create([
            'short_description' => 'test',
        ], null, BotShortDescription::class);

        assertSame('test', $description->shortDescription);
    }
}
