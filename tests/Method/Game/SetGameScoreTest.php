<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Game;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Game\SetGameScore;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\Message;

final class SetGameScoreTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetGameScore(1, 2);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setGameScore', $method->getApiMethod());
        $this->assertSame(
            [
                'user_id' => 1,
                'score' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SetGameScore(
            1,
            2,
            true,
            false,
            10,
            20,
            'id1',
        );

        $this->assertSame(
            [
                'user_id' => 1,
                'score' => 2,
                'force' => true,
                'disable_edit_message' => false,
                'chat_id' => 10,
                'message_id' => 20,
                'inline_message_id' => 'id1',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetGameScore(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);
        $this->assertTrue($preparedResult);

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->send($method);
        $this->assertInstanceOf(Message::class, $preparedResult);
        $this->assertSame(7, $preparedResult->messageId);
    }
}
