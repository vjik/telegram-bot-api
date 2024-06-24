<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Client;

use HttpSoft\Message\Request;
use HttpSoft\Message\Response;
use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\Constraint\Callback;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Vjik\TelegramBot\Api\Client\PsrTelegramClient;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequest;
use Vjik\TelegramBot\Api\Type\InputFile;

final class PsrTelegramClientTest extends TestCase
{
    public function testGet(): void
    {
        $httpRequest = new Request();

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient
            ->expects($this->once())
            ->method('sendRequest')
            ->with($httpRequest)
            ->willReturn(new Response(201));

        $httpRequestFactory = $this->createMock(RequestFactoryInterface::class);
        $httpRequestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', 'https://api.telegram.org/bot04062024/getMe?key=value')
            ->willReturn($httpRequest);

        $client = new PsrTelegramClient(
            '04062024',
            $httpClient,
            $httpRequestFactory,
            new StreamFactory(),
        );

        $response = $client->send(new TelegramRequest(HttpMethod::GET, 'getMe', ['key' => 'value']));

        $this->assertSame(201, $response->statusCode);
    }

    public function testPost(): void
    {
        $httpRequest = new Request();

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient
            ->expects($this->once())
            ->method('sendRequest')
            ->with($httpRequest)
            ->willReturn(new Response(201));

        $httpRequestFactory = $this->createMock(RequestFactoryInterface::class);
        $httpRequestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('POST', 'https://api.telegram.org/bot04062024/logOut')
            ->willReturn($httpRequest);

        $client = new PsrTelegramClient(
            '04062024',
            $httpClient,
            $httpRequestFactory,
            new StreamFactory(),
        );

        $response = $client->send(new TelegramRequest(HttpMethod::POST, 'logOut'));

        $this->assertSame(201, $response->statusCode);
    }

    public function testPostWithData(): void
    {
        $httpRequest = new Request();

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient
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
                        $request->getHeaders()
                    );
                    $this->assertSame('{"chat_id":123,"text":"test"}', $request->getBody()->getContents());
                    return true;
                })
            )
            ->willReturn(new Response(201));

        $httpRequestFactory = $this->createMock(RequestFactoryInterface::class);
        $httpRequestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('POST', 'https://api.telegram.org/bot04062024/sendMessage')
            ->willReturn($httpRequest);

        $client = new PsrTelegramClient(
            '04062024',
            $httpClient,
            $httpRequestFactory,
            new StreamFactory(),
        );

        $response = $client->send(
            new TelegramRequest(HttpMethod::POST, 'sendMessage', ['chat_id' => 123, 'text' => 'test'])
        );

        $this->assertSame(201, $response->statusCode);
    }

    public function testPostWithDataAndFiles(): void
    {
        $httpRequest = new Request();

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient
            ->expects($this->once())
            ->method('sendRequest')
            ->with(
                new Callback(function ($request): bool {
                    $this->assertInstanceOf(Request::class, $request);
                    /** @var Request $request */
                    $requestHeaders = $request->getHeaders();
                    $this->assertSame(['Content-Length', 'Content-Type'], array_keys($requestHeaders));
                    $this->assertSame($requestHeaders['Content-Length'], ['287']);
                    $this->assertSame([0], array_keys($requestHeaders['Content-Type']));
                    $this->assertSame(
                        1,
                        preg_match(
                            '~multipart/form-data; boundary=([\da-f]+.[\da-f]+); charset=utf-8~',
                            $requestHeaders['Content-Type'][0],
                            $matches
                        )
                    );
                    $this->assertStringContainsStringIgnoringLineEndings(
                        <<<TEXT
                            --$matches[1]
                            Content-Disposition: form-data; name="chat_id"
                            Content-Length: 3

                            123
                            --$matches[1]
                            Content-Disposition: form-data; name="photo"; filename="face.png"
                            Content-Length: 14
                            Content-Type: image/png

                            test-file-body
                            --$matches[1]--
                            TEXT,
                        $request->getBody()->getContents()
                    );
                    return true;
                })
            )
            ->willReturn(new Response(201));

        $httpRequestFactory = $this->createMock(RequestFactoryInterface::class);
        $httpRequestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('POST', 'https://api.telegram.org/bot04062024/sendPhoto')
            ->willReturn($httpRequest);

        $client = new PsrTelegramClient(
            '04062024',
            $httpClient,
            $httpRequestFactory,
            new StreamFactory(),
        );

        $response = $client->send(
            new TelegramRequest(
                HttpMethod::POST,
                'sendPhoto',
                [
                    'chat_id' => 123,
                    'photo' => new InputFile(
                        (new StreamFactory())->createStream('test-file-body'),
                        'face.png',
                    ),
                ],
            )
        );

        $this->assertSame(201, $response->statusCode);
    }
}
