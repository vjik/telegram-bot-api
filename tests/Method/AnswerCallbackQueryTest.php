<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\AnswerCallbackQuery;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class AnswerCallbackQueryTest extends TestCase
{
    public function testBase(): void
    {
        $method = new AnswerCallbackQuery('id');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('answerCallbackQuery', $method->getApiMethod());
        $this->assertSame(
            [
                'callback_query_id' => 'id',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new AnswerCallbackQuery('id', 'test', true, 'https://example.com', 23);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('answerCallbackQuery', $method->getApiMethod());
        $this->assertSame(
            [
                'callback_query_id' => 'id',
                'text' => 'test',
                'show_alert' => true,
                'url' => 'https://example.com',
                'cache_time' => 23,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new AnswerCallbackQuery('id');

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}
