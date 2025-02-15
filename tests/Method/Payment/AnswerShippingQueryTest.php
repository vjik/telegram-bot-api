<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Payment\AnswerShippingQuery;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\Payment\ShippingOption;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class AnswerShippingQueryTest extends TestCase
{
    public function testBase(): void
    {
        $method = new AnswerShippingQuery(
            'qid',
            true,
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('answerShippingQuery', $method->getApiMethod());
        assertSame(
            [
                'shipping_query_id' => 'qid',
                'ok' => true,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $option = new ShippingOption('', '', []);
        $method = new AnswerShippingQuery(
            'qid',
            true,
            [$option],
            'error message',
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('answerShippingQuery', $method->getApiMethod());
        assertSame(
            [
                'shipping_query_id' => 'qid',
                'ok' => true,
                'shipping_options' => [$option->toRequestArray()],
                'error_message' => 'error message',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new AnswerShippingQuery(
            'qid',
            true,
        );

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
