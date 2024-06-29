<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Inline\AnswerWebAppQuery;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultContact;

final class AnswerWebAppQueryTest extends TestCase
{
    public function testBase(): void
    {
        $result = new InlineQueryResultContact('1', '+79001234567', 'Vjik');
        $method = new AnswerWebAppQuery('id7', $result);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('answerWebAppQuery', $method->getApiMethod());
        $this->assertSame(
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

        $preparedResult = $method->prepareResult([
            'inline_message_id' => 'idMessage',
        ]);

        $this->assertSame('idMessage', $preparedResult->inlineMessageId);
    }
}
