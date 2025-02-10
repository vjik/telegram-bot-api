<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Transport\CurlTransport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Transport\Curl\CurlTransport;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

use function PHPUnit\Framework\assertSame;

final class CurlTransportTest extends TestCase
{
    public function testGet(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport('test-token', curl: $curl);

        $response = $transport->send(
            'getMe',
            [
                'key' => 'value',
                'array' => [1, 'test'],
            ],
            HttpMethod::GET,
        );

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);
        assertSame(
            [
                CURLOPT_HTTPGET => true,
                CURLOPT_URL => 'https://api.telegram.org/bottest-token/getMe?key=value&array=%5B1%2C%22test%22%5D',
                CURLOPT_RETURNTRANSFER => true,
            ],
            $curl->getOptions()
        );
    }

    public function testPost(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport('test-token', curl: $curl);

        $response = $transport->send('logOut');

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);
        assertSame(
            [
                CURLOPT_POST => true,
                CURLOPT_URL => 'https://api.telegram.org/bottest-token/logOut',
                CURLOPT_POSTFIELDS => [],
                CURLOPT_RETURNTRANSFER => true,
            ],
            $curl->getOptions()
        );
    }

    public function testWithoutCode(): void
    {
        $transport = new CurlTransport(
            'test-token',
            curl: new CurlMock(
                execResult: '{"ok":true,"result":[]}',
            ),
        );

        $response = $transport->send('logOut');

        assertSame(0, $response->statusCode);
    }
}
