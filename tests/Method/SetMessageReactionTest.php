<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetMessageReaction;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ReactionTypeEmoji;

final class SetMessageReactionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetMessageReaction(1, 2);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setMessageReaction', $method->getApiMethod());
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
        $reactionType = new ReactionTypeEmoji('👍');
        $method = new SetMessageReaction(1, 2, [$reactionType], true);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setMessageReaction', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'message_id' => 2,
                'reaction' => [$reactionType->toRequestArray()],
                'is_big' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetMessageReaction(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}
