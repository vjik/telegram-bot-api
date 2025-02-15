<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Transport\ApiResponse;
use Vjik\TelegramBot\Api\FailResult;
use Vjik\TelegramBot\Api\CustomMethod;
use Vjik\TelegramBot\Api\Type\ResponseParameters;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class FailResultTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CustomMethod('getMe');
        $response = new ApiResponse(200, 'test');
        $result = new FailResult($method, $response);

        assertSame($method, $result->method);
        assertSame($response, $result->response);
        assertNull($result->description);
        assertNull($result->parameters);
        assertNull($result->errorCode);
    }

    public function testFull(): void
    {
        $method = new CustomMethod('getMe');
        $response = new ApiResponse(200, 'test');
        $responseParameters = new ResponseParameters();
        $result = new FailResult($method, $response, 'desc', $responseParameters, 200);

        assertSame($method, $result->method);
        assertSame($response, $result->response);
        assertSame('desc', $result->description);
        assertSame($responseParameters, $result->parameters);
        assertSame(200, $result->errorCode);
    }
}
