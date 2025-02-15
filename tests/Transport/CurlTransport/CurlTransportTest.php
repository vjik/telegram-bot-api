<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Transport\CurlTransport;

use CURLStringFile;
use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use stdClass;
use Throwable;
use Vjik\TelegramBot\Api\Transport\Curl\CurlTransport;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Type\InputFile;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class CurlTransportTest extends TestCase
{
    public function testGet(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport($curl);

        $response = $transport->send(
            '//url/getMe',
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
                CURLOPT_URL => '//url/getMe?key=value&array=%5B1%2C%22test%22%5D',
                CURLOPT_RETURNTRANSFER => true,
            ],
            $curl->getOptions(),
        );
    }

    public function testPost(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport($curl);

        $response = $transport->send('//url/logOut');

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);
        assertSame(
            [
                CURLOPT_POST => true,
                CURLOPT_URL => '//url/logOut',
                CURLOPT_POSTFIELDS => [],
                CURLOPT_RETURNTRANSFER => true,
            ],
            $curl->getOptions(),
        );
    }

    public function testPostWithParams(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport($curl);

        $transport->send('//url/setChatTitle', [
            'chat_id' => 123,
            'title' => 'test',
            'object' => new stdClass(),
        ]);

        assertSame(
            [
                CURLOPT_POST => true,
                CURLOPT_URL => '//url/setChatTitle',
                CURLOPT_POSTFIELDS => [
                    'chat_id' => 123,
                    'title' => 'test',
                    'object' => '{}',
                ],
                CURLOPT_RETURNTRANSFER => true,
            ],
            $curl->getOptions(),
        );
    }

    public function testWithoutCode(): void
    {
        $transport = new CurlTransport(
            new CurlMock(
                execResult: '{"ok":true,"result":[]}',
            ),
        );

        $response = $transport->send('logOut');

        assertSame(0, $response->statusCode);
    }

    public function testPostWithLocalFiles(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport($curl);

        $response = $transport->send('//url/sendPhoto', [
            'photo1' => InputFile::fromLocalFile(__DIR__ . '/photo.png'),
            'photo2' => InputFile::fromLocalFile(__DIR__ . '/photo.png', 'photo.png'),
        ]);

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);

        $options = $curl->getOptions();
        assertSame([CURLOPT_POST, CURLOPT_URL, CURLOPT_POSTFIELDS, CURLOPT_RETURNTRANSFER], array_keys($options));
        assertTrue($options[CURLOPT_POST] ?? null);
        assertSame('//url/sendPhoto', $options[CURLOPT_URL] ?? null);
        assertEquals(
            [
                'photo1' => new CURLStringFile(
                    file_get_contents(__DIR__ . '/photo.png'),
                    '',
                ),
                'photo2' => new CURLStringFile(
                    file_get_contents(__DIR__ . '/photo.png'),
                    'photo.png',
                ),
            ],
            $options[CURLOPT_POSTFIELDS] ?? null,
        );
    }

    public function testPostWithStreamFile(): void
    {
        $curl = new CurlMock(
            execResult: '{"ok":true,"result":[]}',
            getinfoResult: [CURLINFO_HTTP_CODE => 200],
        );
        $transport = new CurlTransport($curl);

        $transport->send('sendPhoto', [
            'photo1' => new InputFile(
                (new StreamFactory())->createStream('test1'),
            ),
            'photo2' => new InputFile(
                (new StreamFactory())->createStream('test2'),
                'test.jpg',
            ),
        ]);

        assertEquals(
            [
                'photo1' => new CURLStringFile('test1', ''),
                'photo2' => new CURLStringFile('test2', 'test.jpg'),
            ],
            $curl->getOptions()[CURLOPT_POSTFIELDS] ?? null,
        );
    }

    public function testSeekableStream(): void
    {
        $curl = new CurlMock();
        $transport = new CurlTransport($curl);

        $stream = (new StreamFactory())->createStream('test1');
        $stream->getContents();
        $transport->send('sendPhoto', [
            'photo' => new InputFile($stream),
        ]);

        assertEquals(
            [
                'photo' => new CURLStringFile('test1', ''),
            ],
            $curl->getOptions()[CURLOPT_POSTFIELDS] ?? null,
        );
    }

    public function testSeekableResource(): void
    {
        $curl = new CurlMock();
        $transport = new CurlTransport($curl);

        $resource = fopen(__DIR__ . '/photo.png', 'r');
        stream_get_contents($resource);
        $transport->send('sendPhoto', [
            'photo' => new InputFile($resource),
        ]);

        assertEquals(
            [
                'photo' => new CURLStringFile(
                    file_get_contents(__DIR__ . '/photo.png'),
                    '',
                ),
            ],
            $curl->getOptions()[CURLOPT_POSTFIELDS] ?? null,
        );
    }

    public function testCloseOnException(): void
    {
        $curl = new CurlMock(new RuntimeException());
        $transport = new CurlTransport($curl);

        try {
            $transport->send('getMe');
        } catch (Throwable) {
        }

        assertSame(1, $curl->getCountCallOfClose());
    }
}
