<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Inline\AnswerInlineQuery;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultContact;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultsButton;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class AnswerInlineQueryTest extends TestCase
{
    public function testBase(): void
    {
        $method = new AnswerInlineQuery('id1', []);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('answerInlineQuery', $method->getApiMethod());
        assertSame(
            [
                'inline_query_id' => 'id1',
                'results' => [],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $result = new InlineQueryResultContact('id1', '+79001234567', 'Sergei');
        $button = new InlineQueryResultsButton('test');
        $method = new AnswerInlineQuery('id2', [$result], 500, true, 'n2', $button);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('answerInlineQuery', $method->getApiMethod());
        assertSame(
            [
                'inline_query_id' => 'id2',
                'results' => [
                    $result->toRequestArray(),
                ],
                'cache_time' => 500,
                'is_personal' => true,
                'next_offset' => 'n2',
                'button' => $button->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new AnswerInlineQuery('id', []);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
