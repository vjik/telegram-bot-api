<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Inline\ChosenInlineResult;
use Vjik\TelegramBot\Api\Type\User;

final class ChosenInlineResultTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'user1');
        $chosenInlineResult = new ChosenInlineResult(
            'x1',
            $user,
            'query1',
        );

        $this->assertSame('x1', $chosenInlineResult->resultId);
        $this->assertSame($user, $chosenInlineResult->from);
        $this->assertSame('query1', $chosenInlineResult->query);
        $this->assertNull($chosenInlineResult->location);
        $this->assertNull($chosenInlineResult->inlineMessageId);
    }

    public function testFromTelegramResult(): void
    {
        $chosenInlineResult = (new ObjectFactory())->create([
            'result_id' => 'x1',
            'from' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'user1',
            ],
            'location' => [
                'latitude' => 1.2,
                'longitude' => 3.4,
            ],
            'inline_message_id' => 'm1',
            'query' => 'query1',
        ], null, ChosenInlineResult::class);

        $this->assertSame('x1', $chosenInlineResult->resultId);

        $this->assertSame(1, $chosenInlineResult->from->id);
        $this->assertSame(false, $chosenInlineResult->from->isBot);
        $this->assertSame('user1', $chosenInlineResult->from->firstName);

        $this->assertSame(1.2, $chosenInlineResult->location->latitude);
        $this->assertSame(3.4, $chosenInlineResult->location->longitude);

        $this->assertSame('m1', $chosenInlineResult->inlineMessageId);
        $this->assertSame('query1', $chosenInlineResult->query);
    }
}
