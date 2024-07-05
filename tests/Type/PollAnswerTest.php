<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\PollAnswer;

final class PollAnswerTest extends TestCase
{
    public function testBase(): void
    {
        $answer = new PollAnswer('sadg', [2, 4]);

        $this->assertSame('sadg', $answer->pollId);
        $this->assertSame([2, 4], $answer->optionIds);
        $this->assertNull($answer->voterChat);
        $this->assertNull($answer->user);
    }

    public function testFromTelegramResult(): void
    {
        $answer = (new ObjectFactory())->create([
            'poll_id' => 'sadg',
            'option_ids' => [2, 4],
            'voter_chat' => [
                'id' => 42,
                'type' => 'private',
            ],
            'user' => [
                'id' => 43,
                'is_bot' => false,
                'first_name' => 'John',
            ],
        ], null, PollAnswer::class);

        $this->assertSame('sadg', $answer->pollId);
        $this->assertSame([2, 4], $answer->optionIds);
        $this->assertSame(42, $answer->voterChat?->id);
        $this->assertSame(43, $answer->user?->id);
    }
}
