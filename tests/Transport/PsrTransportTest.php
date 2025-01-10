<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Transport;

use HttpSoft\Message\Request;
use HttpSoft\Message\Response;
use HttpSoft\Message\ResponseFactory;
use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\Constraint\Callback;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Vjik\TelegramBot\Api\Transport\PsrTransport;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Method;
use Vjik\TelegramBot\Api\Type\InputFile;

final class PsrTransportTest extends TestCase
{
    public function testGet(): void
    {
        $httpRequest = new Request();

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with($httpRequest)
            ->willReturn(new Response(201));

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', 'https://api.telegram.org/bot04062024/getMe?key=value&array=%5B1%2C%22test%22%5D')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            '04062024',
            $client,
            $requestFactory,
            new StreamFactory(),
        );

        $response = $transport->send(
            'getMe',
            [
            'key' => 'value',
            'array' => [1, 'test'],
            ],
            HttpMethod::GET,
        );

        $this->assertSame(201, $response->statusCode);
    }

    public function testPost(): void
    {
        $httpRequest = new Request();

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with($httpRequest)
            ->willReturn(new Response(201));

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('POST', 'https://api.telegram.org/bot04062024/logOut')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            '04062024',
            $client,
            $requestFactory,
            new StreamFactory(),
        );

        $response = $transport->send('logOut');

        $this->assertSame(201, $response->statusCode);
    }

    public function testPostWithData(): void
    {
        $httpRequest = new Request();

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with(
                new Callback(function ($request): bool {
                    $this->assertInstanceOf(Request::class, $request);
                    /** @var Request $request */
                    $this->assertSame(
                        [
                            'Content-Length' => ['29'],
                            'Content-Type' => ['application/json; charset=utf-8'],
                        ],
                        $request->getHeaders(),
                    );
                    $this->assertSame('{"chat_id":123,"text":"test"}', $request->getBody()->getContents());
                    return true;
                }),
            )
            ->willReturn(new Response(201));

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('POST', 'https://api.telegram.org/bot04062024/sendMessage')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            '04062024',
            $client,
            $requestFactory,
            new StreamFactory(),
        );

        $response = $transport->send('sendMessage', ['chat_id' => 123, 'text' => 'test']);

        $this->assertSame(201, $response->statusCode);
    }

    public function testPostWithDataAndFiles(): void
    {
        $httpRequest = new Request();

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with(
                new Callback(function ($request): bool {
                    $this->assertInstanceOf(Request::class, $request);
                    /** @var Request $request */
                    $requestHeaders = $request->getHeaders();
                    $this->assertSame(['Content-Length', 'Content-Type'], array_keys($requestHeaders));
                    $this->assertSame($requestHeaders['Content-Length'], ['332']);
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

                            123
                            --$matches[1]
                            Content-Disposition: form-data; name="caption"

                            hello
                            --$matches[1]
                            Content-Disposition: form-data; name="photo"; filename="face.png"
                            Content-Type: image/png

                            test-file-body
                            --$matches[1]--
                            TEXT,
                        $request->getBody()->getContents(),
                    );
                    return true;
                }),
            )
            ->willReturn(new Response(201));

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('POST', 'https://api.telegram.org/bot04062024/sendPhoto')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            '04062024',
            $client,
            $requestFactory,
            new StreamFactory(),
        );

        $response = $transport->send(
            'sendPhoto',
            [
                'chat_id' => 123,
                'caption' => 'hello',
                'photo' => new InputFile(
                    (new StreamFactory())->createStream('test-file-body'),
                    'face.png',
                ),
            ],
        );

        $this->assertSame(201, $response->statusCode);
    }

    public function testRewind(): void
    {
        $streamFactory = new StreamFactory();

        $httpResponse = new Response(201, body: $streamFactory->createStream('hello'));
        $httpResponse->getBody()->getContents();

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($httpResponse);

        $httpRequestFactory = $this->createMock(RequestFactoryInterface::class);

        $transport = new PsrTransport(
            '04062024',
            $client,
            $httpRequestFactory,
            $streamFactory,
        );

        $response = $transport->send('getMe');

        $this->assertSame(201, $response->statusCode);
        $this->assertSame('hello', $response->body);
    }
}
