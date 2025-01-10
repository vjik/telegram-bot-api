<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests;

use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Transport\TelegramResponse;
use Vjik\TelegramBot\Api\LogType;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Tests\Support\StubTelegramRequest;

final class LogTypeTest extends TestCase
{
    public static function dataCreateSendRequestContext(): Generator
    {
        $request = new StubTelegramRequest(
            HttpMethod::POST,
            'getMe',
            ['param1' => 'Привет'],
        );
        yield 'base' => [
            [
                'type' => LogType::SEND_REQUEST,
                'payload' => '{"param1":"Привет"}',
                'request' => $request,
            ],
            $request,
        ];

        $request = new StubTelegramRequest(
            HttpMethod::POST,
            'getMe',
            ['param1' => fopen('php://temp', 'r+')],
        );
        yield 'json-error' => [
            [
                'type' => LogType::SEND_REQUEST,
                'payload' => '%UNABLE_DATA%',
                'request' => $request,
            ],
            $request,
        ];
    }

    #[DataProvider('dataCreateSendRequestContext')]
    public function testCreateSendRequestContext(array $expected, TelegramRequestInterface $request): void
    {
        $context = LogType::createSendRequestContext($request);
        $this->assertSame($expected, $context);
    }

    public static function dataCreateSuccessResultContext(): Generator
    {
        $request = new StubTelegramRequest();
        $response = new TelegramResponse(200, '');
        $decodedResponse = ['param1' => 'Привет'];
        yield 'base' => [
            [
                'type' => LogType::SUCCESS_RESULT,
                'payload' => '{"param1":"Привет"}',
                'request' => $request,
                'response' => $response,
                'decodedResponse' => $decodedResponse,
            ],
            $request,
            $response,
            $decodedResponse,
        ];

        $request = new StubTelegramRequest();
        $response = new TelegramResponse(200, '{"param1":"Привет"}');
        $decodedResponse = fopen('php://temp', 'r+');
        yield 'json-error' => [
            [
                'type' => LogType::SUCCESS_RESULT,
                'payload' => '{"param1":"Привет"}',
                'request' => $request,
                'response' => $response,
                'decodedResponse' => $decodedResponse,
            ],
            $request,
            $response,
            $decodedResponse,
        ];
    }

    #[DataProvider('dataCreateSuccessResultContext')]
    public function testCreateSuccessResultContext(
        array $expected,
        TelegramRequestInterface $request,
        TelegramResponse $response,
        mixed $decodedResponse,
    ): void {
        $context = LogType::createSuccessResultContext($request, $response, $decodedResponse);
        $this->assertSame($expected, $context);
    }

    public function testCreateFailResultContext(): void
    {
        $request = new StubTelegramRequest();
        $response = new TelegramResponse(200, 'test');
        $decodedResponse = ['param1' => 'Привет'];

        $context = LogType::createFailResultContext($request, $response, $decodedResponse);

        $this->assertSame(
            [
                'type' => LogType::FAIL_RESULT,
                'payload' => 'test',
                'request' => $request,
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
