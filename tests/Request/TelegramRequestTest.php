<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Request;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequest;
use Vjik\TelegramBot\Api\Type\InputFile;

final class TelegramRequestTest extends TestCase
{
    public function testBase(): void
    {
        $request = new TelegramRequest(
            HttpMethod::POST,
            'getMe',
            ['param1' => 'value1'],
            ['photo' => new InputFile((new StreamFactory())->createStream('test'))],
            static fn($v) => $v + 1,
        );

        $this->assertSame(HttpMethod::POST, $request->getHttpMethod());
        $this->assertSame('getMe', $request->getApiMethod());
        $this->assertSame(['param1' => 'value1'], $request->getData());

        $files = $request->getFiles();
        $this->assertSame(['photo'], array_keys($files));
        $this->assertInstanceOf(InputFile::class, $files['photo']);
        $this->assertSame('test', $files['photo']->resource->getContents());

        $this->assertSame(33, $request->prepareResult(32));
    }

    public function testWithoutSuccessCallback(): void
    {
        $request = new TelegramRequest(
            HttpMethod::POST,
            'getMe',
        );

        $this->assertSame(32, $request->prepareResult(32));
    }
}
