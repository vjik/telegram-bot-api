<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Payment\AnswerPreCheckoutQuery;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class AnswerPreCheckoutQueryTest extends TestCase
{
    public function testBase(): void
    {
        $method = new AnswerPreCheckoutQuery(
            'qid',
            true,
        );

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('answerPreCheckoutQuery', $method->getApiMethod());
        $this->assertSame(
            [
                'pre_checkout_query_id' => 'qid',
                'ok' => true,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new AnswerPreCheckoutQuery(
            'qid',
            true,
            'error message',
        );

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('answerPreCheckoutQuery', $method->getApiMethod());
        $this->assertSame(
            [
                'pre_checkout_query_id' => 'qid',
                'ok' => true,
                'error_message' => 'error message',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new AnswerPreCheckoutQuery(
            'qid',
            true,
        );

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        $this->assertTrue($preparedResult);
    }
}
