<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests;

use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\CustomMethod;
use Vjik\TelegramBot\Api\LogContextFactory;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Transport\ApiResponse;
use Vjik\TelegramBot\Api\LogType;

final class LogContextFactoryTest extends TestCase
{
    public static function dataSendRequest(): Generator
    {
        $method = new CustomMethod(
            'getMe',
            ['param1' => 'Привет'],
        );
        yield 'base' => [
            [
                'type' => LogType::SEND_REQUEST,
                'payload' => ['param1' => 'Привет'],
                'method' => $method,
            ],
            $method,
        ];

        $handle = fopen('php://temp', 'r+');
        $method = new CustomMethod(
            'getMe',
            ['param1' => $handle],
        );
        yield 'json-error' => [
            [
                'type' => LogType::SEND_REQUEST,
                'payload' => ['param1' => $handle],
                'method' => $method,
            ],
            $method,
        ];
    }

    #[DataProvider('dataSendRequest')]
    public function testSendRequest(
        array $expected,
        MethodInterface $request,
    ): void {
        $context = LogContextFactory::sendRequest($request);
        $this->assertSame($expected, $context);
    }

    public static function dataSuccessResult(): Generator
    {
        $method = new CustomMethod('getMe');
        $response = new ApiResponse(200, '');
        $decodedResponse = ['param1' => 'Привет'];
        yield 'base' => [
            [
                'type' => LogType::SUCCESS_RESULT,
                'payload' => $decodedResponse,
                'method' => $method,
                'response' => $response,
                'decodedResponse' => $decodedResponse,
            ],
            $method,
            $response,
            $decodedResponse,
        ];
    }

    #[DataProvider('dataSuccessResult')]
    public function testSuccessResult(
        array $expected,
        MethodInterface $request,
        ApiResponse $response,
        array $decodedResponse,
    ): void {
        $context = LogContextFactory::successResult($request, $response, $decodedResponse);
        $this->assertSame($expected, $context);
    }

    public function testFailResult(): void
    {
        $method = new CustomMethod('getMe');
        $response = new ApiResponse(200, 'test');
        $decodedResponse = ['param1' => 'Привет'];

        $context = LogContextFactory::failResult($method, $response, $decodedResponse);

        $this->assertSame(
            [
                'type' => LogType::FAIL_RESULT,
                'payload' => 'test',
                'method' => $method,
                'response' => $response,
                'decodedResponse' => $decodedResponse,
            ],
            $context,
        );
    }

    public function testParseResult(): void
    {
        $context = LogContextFactory::parseResultError('test');

        $this->assertSame(
            [
                'type' => LogType::PARSE_RESULT_ERROR,
                'payload' => 'test',
            ],
            $context,
        );
    }
}
