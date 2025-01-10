<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Game;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Game\GetGameHighScores;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\Game\GameHighScore;

final class GetGameHighScoresTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetGameHighScores(1);

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getGameHighScores', $method->getApiMethod());
        $this->assertSame(
            [
                'user_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new GetGameHighScores(1, 2, 3, 'test');

        $this->assertSame(
            [
                'user_id' => 1,
                'chat_id' => 2,
                'message_id' => 3,
                'inline_message_id' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetGameHighScores(1);

        $preparedResult = TestHelper::createSuccessStubApi([
            [
                'position' => 2,
                'user' => [
                    'id' => 1,
                    'is_bot' => false,
                    'first_name' => 'test',
                ],
                'score' => 300,
            ],
        ])->call($method);

        $this->assertCount(1, $preparedResult);
        $this->assertInstanceOf(GameHighScore::class, $preparedResult[0]);
        $this->assertSame(2, $preparedResult[0]->position);
    }
}
