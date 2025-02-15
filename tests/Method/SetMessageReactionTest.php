<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetMessageReaction;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ReactionTypeEmoji;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetMessageReactionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetMessageReaction(1, 2);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setMessageReaction', $method->getApiMethod());
        assertSame(
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

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setMessageReaction', $method->getApiMethod());
        assertSame(
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

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
