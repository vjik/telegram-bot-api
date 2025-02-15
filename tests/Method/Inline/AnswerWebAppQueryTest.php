<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Inline\AnswerWebAppQuery;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultContact;

use function PHPUnit\Framework\assertSame;

final class AnswerWebAppQueryTest extends TestCase
{
    public function testBase(): void
    {
        $result = new InlineQueryResultContact('1', '+79001234567', 'Vjik');
        $method = new AnswerWebAppQuery('id7', $result);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('answerWebAppQuery', $method->getApiMethod());
        assertSame(
            [
                'web_app_query_id' => 'id7',
                'result' => $result->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new AnswerWebAppQuery('id', new InlineQueryResultContact('1', '+79001234567', 'Vjik'));

        $preparedResult = TestHelper::createSuccessStubApi([
            'inline_message_id' => 'idMessage',
        ])->call($method);

        assertSame('idMessage', $preparedResult->inlineMessageId);
    }
}
