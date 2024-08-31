<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Client;

use HttpSoft\Message\Request;
use HttpSoft\Message\RequestFactory;
use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Client\ApiUrlGenerator;
use Vjik\TelegramBot\Api\Client\HttpAdapter;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequest;
use Vjik\TelegramBot\Api\Type\InputFile;

final class HttpAdapterTest extends TestCase
{
    private readonly HttpAdapter $httpAdapter;

    protected function setUp(): void
    {
        $this->httpAdapter = new HttpAdapter(
            new RequestFactory(),
            new StreamFactory(),
            new ApiUrlGenerator('04062024', 'https://api.telegram.org'),
        );
    }

    public function testGet(): void
    {
        $httpRequest = $this->httpAdapter->toHttpRequest(
            new TelegramRequest(HttpMethod::GET, 'getMe', [
                'key' => 'value',
                'array' => [1, 'test'],
            ]),
        );

        $this->assertSame('GET', $httpRequest->getMethod());
        $this->assertSame('https://api.telegram.org/bot04062024/getMe?key=value&array=%5B1%2C%22test%22%5D', (string) $httpRequest->getUri());
    }

    public function testPost(): void
    {
        $httpRequest = $this->httpAdapter->toHttpRequest(
            new TelegramRequest(HttpMethod::POST, 'logOut'),
        );

        $this->assertSame('POST', $httpRequest->getMethod());
        $this->assertSame('https://api.telegram.org/bot04062024/logOut', (string) $httpRequest->getUri());
    }

    public function testPostWithData(): void
    {
        $httpRequest = $this->httpAdapter->toHttpRequest(
            new TelegramRequest(HttpMethod::POST, 'sendMessage', ['chat_id' => 123, 'text' => 'test']),
        );

        $this->assertSame('POST', $httpRequest->getMethod());
        $this->assertSame('https://api.telegram.org/bot04062024/sendMessage', (string) $httpRequest->getUri());

        $this->assertInstanceOf(Request::class, $httpRequest);
        $this->assertSame(
            [
                'Host' => ['api.telegram.org'],
                'Content-Length' => ['29'],
                'Content-Type' => ['application/json; charset=utf-8'],
            ],
            $httpRequest->getHeaders(),
        );
        $this->assertSame('{"chat_id":123,"text":"test"}', $httpRequest->getBody()->getContents());
    }

    public function testPostWithDataAndFiles(): void
    {
        $httpRequest = $this->httpAdapter->toHttpRequest(
            new TelegramRequest(
                HttpMethod::POST,
                'sendPhoto',
                [
                    'chat_id' => 123,
                    'caption' => 'hello',
                    'photo' => new InputFile(
                        (new StreamFactory())->createStream('test-file-body'),
                        'face.png',
                    ),
                ],
            ),
        );

        $this->assertSame('POST', $httpRequest->getMethod());
        $this->assertSame('https://api.telegram.org/bot04062024/sendPhoto', (string) $httpRequest->getUri());

        $this->assertInstanceOf(Request::class, $httpRequest);
        $requestHeaders = $httpRequest->getHeaders();
        $this->assertSame(['Host', 'Content-Length', 'Content-Type'], array_keys($requestHeaders));
        $this->assertSame($requestHeaders['Content-Length'], ['390']);
        $this->assertSame([0], array_keys($requestHeaders['Content-Type']));
        $this->assertSame(
            1,
            preg_match(
                '~multipart/form-data; boundary=([\da-f]+.[\da-f]+); charset=utf-8~',
                $requestHeaders['Content-Type'][0],
                $matches,
            ),
        );
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<TEXT
                            --$matches[1]
                            Content-Disposition: form-data; name="chat_id"
                            Content-Length: 3

                            123
                            --$matches[1]
                            Content-Disposition: form-data; name="caption"
                            Content-Length: 5

                            hello
                            --$matches[1]
                            Content-Disposition: form-data; name="photo"; filename="face.png"
                            Content-Length: 14
                            Content-Type: image/png

                            test-file-body
                            --$matches[1]--
                            TEXT,
            $httpRequest->getBody()->getContents(),
        );
    }
}
