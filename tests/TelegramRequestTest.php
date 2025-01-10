<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\IntegerValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequest;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InputFile;

final class TelegramRequestTest extends TestCase
{
    public function testBase(): void
    {
        $photo = new InputFile((new StreamFactory())->createStream('test'));
        $request = new TelegramRequest(
            HttpMethod::POST,
            'getMe',
            ['param1' => 'value1', 'photo' => $photo],
            new IntegerValue(),
        );

        $this->assertSame(HttpMethod::POST, $request->getHttpMethod());
        $this->assertSame('getMe', $request->getApiMethod());
        $this->assertSame(['param1' => 'value1', 'photo' => $photo], $request->getData());

        $this->assertSame(33, TestHelper::createSuccessStubApi(33)->send($request));
    }

    public function testWithoutSuccessCallback(): void
    {
        $request = new TelegramRequest(
            HttpMethod::POST,
            'getMe',
        );

        $this->assertSame(33, TestHelper::createSuccessStubApi(33)->send($request));
    }
}
