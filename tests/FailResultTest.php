<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Client\TelegramResponse;
use Vjik\TelegramBot\Api\FailResult;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequest;
use Vjik\TelegramBot\Api\Type\ResponseParameters;

final class FailResultTest extends TestCase
{
    public function testBase(): void
    {
        $request = new TelegramRequest(HttpMethod::GET, 'getMe');
        $response = new TelegramResponse(200, 'test');
        $result = new FailResult($request, $response);

        $this->assertSame($request, $result->request);
        $this->assertSame($response, $result->response);
        $this->assertNull($result->description);
        $this->assertNull($result->parameters);
        $this->assertNull($result->errorCode);
    }

    public function testFull(): void
    {

        $request = new TelegramRequest(HttpMethod::GET, 'getMe');
        $response = new TelegramResponse(200, 'test');
        $responseParameters = new ResponseParameters();
        $result = new FailResult($request, $response, 'desc', $responseParameters, 200);

        $this->assertSame($request, $result->request);
        $this->assertSame($response, $result->response);
        $this->assertSame('desc', $result->description);
        $this->assertSame($responseParameters, $result->parameters);
        $this->assertSame(200, $result->errorCode);
    }
}
