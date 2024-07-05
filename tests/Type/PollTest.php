<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Poll;
use Vjik\TelegramBot\Api\Type\PollOption;

final class PollTest extends TestCase
{
    public function testBase(): void
    {
        $option = new PollOption('One', 12);
        $poll = new Poll(
            '12',
            'Why?',
            [$option],
            42,
            true,
            false,
            'regular',
            true,
        );

        $this->assertSame('12', $poll->id);
        $this->assertSame('Why?', $poll->question);
        $this->assertSame([$option], $poll->options);
        $this->assertSame(42, $poll->totalVoterCount);
        $this->assertTrue($poll->isClosed);
        $this->assertFalse($poll->isAnonymous);
        $this->assertSame('regular', $poll->type);
        $this->assertTrue($poll->allowsMultipleAnswers);
        $this->assertNull($poll->correctOptionId);
        $this->assertNull($poll->explanation);
        $this->assertNull($poll->explanationEntities);
        $this->assertNull($poll->openPeriod);
        $this->assertNull($poll->closeDate);
    }

    public function testFromTelegramResult(): void
    {
        $poll = (new ObjectFactory())->create([
            'id' => '12',
            'question' => 'Why?',
            'options' => [
                ['text' => 'One', 'voter_count' => 12],
            ],
            'total_voter_count' => 42,
            'is_closed' => true,
            'is_anonymous' => false,
            'type' => 'regular',
            'allows_multiple_answers' => true,
            'question_entities' => [
                [
                    'offset' => 0,
                    'length' => 35,
                    'type' => 'bold',
                ],
            ],
            'correct_option_id' => 23,
            'explanation' => 'Because',
            'explanation_entities' => [
                [
                    'offset' => 0,
                    'length' => 31,
                    'type' => 'bold',
                ],
            ],
            'open_period' => 123,
            'close_date' => 456,
        ], null, Poll::class);

        $this->assertSame('12', $poll->id);
        $this->assertSame('Why?', $poll->question);

        $this->assertCount(1, $poll->options);
        $this->assertSame('One', $poll->options[0]->text);

        $this->assertSame(42, $poll->totalVoterCount);
        $this->assertTrue($poll->isClosed);
        $this->assertFalse($poll->isAnonymous);
        $this->assertSame('regular', $poll->type);
        $this->assertTrue($poll->allowsMultipleAnswers);

        $this->assertCount(1, $poll->questionEntities);
        $this->assertSame(35, $poll->questionEntities[0]->length);

        $this->assertSame(23, $poll->correctOptionId);
        $this->assertSame('Because', $poll->explanation);

        $this->assertCount(1, $poll->explanationEntities);
        $this->assertSame(31, $poll->explanationEntities[0]->length);

        $this->assertSame(123, $poll->openPeriod);
        $this->assertSame(456, $poll->closeDate);
    }
}
