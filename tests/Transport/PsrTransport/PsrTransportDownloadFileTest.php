<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Transport\PsrTransport;

use Http\Client\Exception\RequestException;
use HttpSoft\Message\Request;
use HttpSoft\Message\Response;
use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Throwable;
use Vjik\TelegramBot\Api\Transport\DownloadFileException;
use Vjik\TelegramBot\Api\Transport\PsrTransport;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class PsrTransportDownloadFileTest extends TestCase
{
    public function testBase(): void
    {
        $streamFactory = new StreamFactory();
        $httpRequest = new Request();

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with($httpRequest)
            ->willReturn(new Response(200, body: $streamFactory->createStream('hello-content')));

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', 'https://example.com/test.txt')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            $client,
            $requestFactory,
            $streamFactory,
        );

        $result = $transport->downloadFile('https://example.com/test.txt');

        assertSame('hello-content', $result);
    }

    public function testSendRequestException(): void
    {
        $httpRequest = new Request();
        $requestException = new RequestException('test', $httpRequest);

        $client = $this->createMock(ClientInterface::class);
        $client
            ->method('sendRequest')
            ->with($httpRequest)
            ->willThrowException($requestException);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory->method('createRequest')->willReturn($httpRequest);

        $transport = new PsrTransport(
            $client,
            $requestFactory,
            new StreamFactory(),
        );

        $exception = null;
        try {
            $transport->downloadFile('https://example.com/test.txt');
        } catch (Throwable $exception) {
        }

        assertInstanceOf(DownloadFileException::class, $exception);
        assertSame('test', $exception->getMessage());
        assertSame($requestException, $exception->getPrevious());
    }

    public function testRewind(): void
    {
        $streamFactory = new StreamFactory();
        $httpRequest = new Request();

        $httpResponse = new Response(200, body: $streamFactory->createStream('hello-content'));
        $httpResponse->getBody()->getContents();

        $client = $this->createMock(ClientInterface::class);
        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with($httpRequest)
            ->willReturn($httpResponse);

        $requestFactory = $this->createMock(RequestFactoryInterface::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', 'https://example.com/test.txt')
            ->willReturn($httpRequest);

        $transport = new PsrTransport(
            $client,
            $requestFactory,
            $streamFactory,
        );

        $result = $transport->downloadFile('https://example.com/test.txt');

        assertSame('hello-content', $result);
    }
}
