<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Transport\ApiResponse;
use Vjik\TelegramBot\Api\FailResult;
use Vjik\TelegramBot\Api\CustomMethod;
use Vjik\TelegramBot\Api\Type\ResponseParameters;

final class FailResultTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CustomMethod('getMe');
        $response = new ApiResponse(200, 'test');
        $result = new FailResult($method, $response);

        $this->assertSame($method, $result->method);
        $this->assertSame($response, $result->response);
        $this->assertNull($result->description);
        $this->assertNull($result->parameters);
        $this->assertNull($result->errorCode);
    }

    public function testFull(): void
    {
        $method = new CustomMethod('getMe');
        $response = new ApiResponse(200, 'test');
        $responseParameters = new ResponseParameters();
        $result = new FailResult($method, $response, 'desc', $responseParameters, 200);

        $this->assertSame($method, $result->method);
        $this->assertSame($response, $result->response);
        $this->assertSame('desc', $result->description);
        $this->assertSame($responseParameters, $result->parameters);
        $this->assertSame(200, $result->errorCode);
    }
}
