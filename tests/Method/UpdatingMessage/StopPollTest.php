<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\StopPoll;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;

final class StopPollTest extends TestCase
{
    public function testBase(): void
    {
        $method = new StopPoll(1, 2);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('stopPoll', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'message_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('hello')]]);
        $method = new StopPoll(1, 2, 'bid', $replyMarkup);

        $this->assertSame(
            [
                'business_connection_id' => 'bid',
                'chat_id' => 1,
                'message_id' => 2,
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData()
        );
    }

    public function testPrepareResult(): void
    {
        $method = new StopPoll(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi([
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
        ])->send($method);

        $this->assertSame('12', $preparedResult->id);
    }
}
