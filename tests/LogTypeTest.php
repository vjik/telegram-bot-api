<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests;

use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Transport\ApiResponse;
use Vjik\TelegramBot\Api\LogType;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

final class LogTypeTest extends TestCase
{
    public static function dataCreateSendRequestContext(): Generator
    {
        $method = new Method(
            'getMe',
            ['param1' => 'Привет'],
        );
        yield 'base' => [
            [
                'type' => LogType::SEND_REQUEST,
                'payload' => '{"param1":"Привет"}',
                'method' => $method,
            ],
            $method,
        ];

        $method = new Method(
            'getMe',
            ['param1' => fopen('php://temp', 'r+')],
        );
        yield 'json-error' => [
            [
                'type' => LogType::SEND_REQUEST,
                'payload' => '%UNABLE_DATA%',
                'method' => $method,
            ],
            $method,
        ];
    }

    #[DataProvider('dataCreateSendRequestContext')]
    public function testCreateSendRequestContext(
        array $expected,
        MethodInterface $request,
    ): void {
        $context = LogType::createSendRequestContext($request);
        $this->assertSame($expected, $context);
    }

    public static function dataCreateSuccessResultContext(): Generator
    {
        $method = new Method('getMe');
        $response = new ApiResponse(200, '');
        $decodedResponse = ['param1' => 'Привет'];
        yield 'base' => [
            [
                'type' => LogType::SUCCESS_RESULT,
                'payload' => '{"param1":"Привет"}',
                'method' => $method,
                'response' => $response,
                'decodedResponse' => $decodedResponse,
            ],
            $method,
            $response,
            $decodedResponse,
        ];

        $method = new Method('getMe');
        $response = new ApiResponse(200, '{"param1":"Привет"}');
        $decodedResponse = fopen('php://temp', 'r+');
        yield 'json-error' => [
            [
                'type' => LogType::SUCCESS_RESULT,
                'payload' => '{"param1":"Привет"}',
                'method' => $method,
                'response' => $response,
                'decodedResponse' => $decodedResponse,
            ],
            $method,
            $response,
            $decodedResponse,
        ];
    }

    #[DataProvider('dataCreateSuccessResultContext')]
    public function testCreateSuccessResultContext(
        array $expected,
        MethodInterface $request,
        ApiResponse $response,
        mixed $decodedResponse,
    ): void {
        $context = LogType::createSuccessResultContext($request, $response, $decodedResponse);
        $this->assertSame($expected, $context);
    }

    public function testCreateFailResultContext(): void
    {
        $method = new Method('getMe');
        $response = new ApiResponse(200, 'test');
        $decodedResponse = ['param1' => 'Привет'];

        $context = LogType::createFailResultContext($method, $response, $decodedResponse);

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

    public function testCreateParseResultContext(): void
    {
        $context = LogType::createParseResultErrorContext('test');

        $this->assertSame(
            [
                'type' => LogType::PARSE_RESULT_ERROR,
                'payload' => 'test',
            ],
            $context,
        );
    }
}
