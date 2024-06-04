<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InlineQuery;
use Vjik\TelegramBot\Api\Type\Location;
use Vjik\TelegramBot\Api\Type\User;

final class InlineQueryTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'first_name');
        $inlineQuery = new InlineQuery(
            'id1',
            $user,
            'query1',
            'offset2',
        );

        $this->assertSame('id1', $inlineQuery->id);
        $this->assertSame($user, $inlineQuery->from);
        $this->assertSame('query1', $inlineQuery->query);
        $this->assertSame('offset2', $inlineQuery->offset);
        $this->assertNull($inlineQuery->chatType);
        $this->assertNull($inlineQuery->location);
    }

    public function testFromTelegramResult(): void
    {
        $inlineQuery = InlineQuery::fromTelegramResult([
            'id' => 'id1',
            'from' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'user1',
            ],
            'query' => 'query1',
            'offset' => 'offset2',
            'chat_type' => 'channel',
            'location' => [
                'latitude' => 1.2,
                'longitude' => 3.4,
            ],
        ]);

        $this->assertSame('id1', $inlineQuery->id);

        $this->assertSame(1, $inlineQuery->from->id);
        $this->assertSame(false, $inlineQuery->from->isBot);
        $this->assertSame('user1', $inlineQuery->from->firstName);

        $this->assertSame('query1', $inlineQuery->query);
        $this->assertSame('offset2', $inlineQuery->offset);
        $this->assertSame('channel', $inlineQuery->chatType);

        $this->assertInstanceOf(Location::class, $inlineQuery->location);
        $this->assertSame(1.2, $inlineQuery->location->latitude);
        $this->assertSame(3.4, $inlineQuery->location->longitude);
    }
}
