<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Transport\CurlTransport;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;
use Vjik\TelegramBot\Api\Curl\CurlException;
use Vjik\TelegramBot\Api\Tests\Curl\CurlMock;
use Vjik\TelegramBot\Api\Transport\CurlTransport;
use Vjik\TelegramBot\Api\Transport\DownloadFileException;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class CurlTransportDownloadFileTest extends TestCase
{
    public function testBase(): void
    {
        $curl = new CurlMock('hello-content');
        $transport = new CurlTransport($curl);

        $result = $transport->downloadFile('https://example.test/hello.jpg');

        assertSame('hello-content', $result);
        assertSame(
            [
                CURLOPT_URL => 'https://example.test/hello.jpg',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FAILONERROR => true,
            ],
            $curl->getOptions(),
        );
    }

    public function testInitException(): void
    {
        $initException = new CurlException('test');
        $curl = new CurlMock(initException: $initException);
        $transport = new CurlTransport($curl);

        $exception = null;
        try {
            $transport->downloadFile('https://example.test/hello.jpg');
        } catch (Throwable $exception) {
        }

        assertInstanceOf(DownloadFileException::class, $exception);
        assertSame('test', $exception->getMessage());
        assertSame($initException, $exception->getPrevious());
    }

    public function testExecException(): void
    {
        $execException = new CurlException('test');
        $curl = new CurlMock(execResult: $execException);
        $transport = new CurlTransport($curl);

        $exception = null;
        try {
            $transport->downloadFile('https://example.test/hello.jpg');
        } catch (Throwable $exception) {
        }

        assertInstanceOf(DownloadFileException::class, $exception);
        assertSame('test', $exception->getMessage());
        assertSame($execException, $exception->getPrevious());
    }

    public function testCloseOnException(): void
    {
        $curl = new CurlMock(new RuntimeException());
        $transport = new CurlTransport($curl);

        try {
            $transport->downloadFile('https://example.test/hello.jpg');
        } catch (Throwable) {
        }

        assertSame(1, $curl->getCountCallOfClose());
    }
}
