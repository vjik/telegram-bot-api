<?php

declare(strict_types=1);

namespace Method\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Inline\SavePreparedInlineMessage;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultGame;
use Vjik\TelegramBot\Api\Type\Inline\PreparedInlineMessage;

final class SavePreparedInlineMessageTest extends TestCase
{
    public function testBase(): void
    {
        $result = new InlineQueryResultGame('tid', 'Hello');
        $method = new SavePreparedInlineMessage(93, $result);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('savePreparedInlineMessage', $method->getApiMethod());
        $this->assertSame(
            [
                'user_id' => 93,
                'result' => $result->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $result = new InlineQueryResultGame('tid', 'Hello');
        $method = new SavePreparedInlineMessage(91, $result, true, false, true, false);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('savePreparedInlineMessage', $method->getApiMethod());
        $this->assertSame(
            [
                'user_id' => 91,
                'result' => $result->toRequestArray(),
                'allow_user_chats' => true,
                'allow_bot_chats' => false,
                'allow_group_chats' => true,
                'allow_channel_chats' => false,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SavePreparedInlineMessage(93, new InlineQueryResultGame('tid', 'Hello'));

        $preparedResult = TestHelper::createSuccessStubApi([
            'id' => 'testId',
            'expiration_date' => 1731917862,
        ])->send($method);

        $this->assertInstanceOf(PreparedInlineMessage::class, $preparedResult);
        $this->assertSame('testId', $preparedResult->id);
        $this->assertSame(1731917862, $preparedResult->expirationDate->getTimestamp());
    }
}
