<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Transport\NativeTransport;

use PHPUnit\Framework\TestCase;
use stdClass;
use Vjik\TelegramBot\Api\Tests\Transport\NativeTransport\StreamMock\StreamMock;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Transport\NativeTransport;
use Vjik\TelegramBot\Api\Type\InputFile;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertStringContainsString;
use function PHPUnit\Framework\assertStringEndsWith;
use function PHPUnit\Framework\assertStringStartsWith;
use function PHPUnit\Framework\assertTrue;

final class NativeTransportTest extends TestCase
{
    public function testGet(): void
    {
        $transport = new NativeTransport();

        StreamMock::enable(
            responseHeaders: [
                'HTTP/1.1 200 OK',
                'Content-Type: text/json',
            ],
            responseBody: '{"ok":true,"result":[]}',
        );

        $response = $transport->send(
            'http://url/getMe',
            [
                'key' => 'value',
                'array' => [1, 'test'],
            ],
            HttpMethod::GET,
        );

        $request = StreamMock::disable();

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);
        assertSame(
            [
                'path' => 'http://url/getMe?key=value&array=%5B1%2C%22test%22%5D',
                'options' => [
                    'http' => [
                        'method' => 'GET',
                        'ignore_errors' => true,
                    ],
                ],
            ],
            $request,
        );
    }

    public function testPost(): void
    {
        $transport = new NativeTransport();

        StreamMock::enable(
            responseHeaders: [
                'HTTP/1.1 200 OK',
                'Content-Type: text/json',
            ],
            responseBody: '{"ok":true,"result":[]}',
        );

        $response = $transport->send('http://url/logOut');

        $request = StreamMock::disable();

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);
        assertSame(
            [
                'path' => 'http://url/logOut',
                'options' => [
                    'http' => [
                        'method' => 'POST',
                        'header' => 'Content-type: application/x-www-form-urlencoded',
                        'content' => '',
                        'ignore_errors' => true,
                    ],
                ],
            ],
            $request,
        );
    }

    public function testPostWithParams(): void
    {
        $transport = new NativeTransport();

        StreamMock::enable(
            responseHeaders: [
                'HTTP/1.1 200 OK',
                'Content-Type: text/json',
            ],
            responseBody: '{"ok":true,"result":[]}',
        );

        $response = $transport->send('http://url/setChatTitle', [
            'chat_id' => 123,
            'title' => 'test',
            'object' => new stdClass(),
        ]);

        $request = StreamMock::disable();

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);
        assertSame(
            [
                'path' => 'http://url/setChatTitle',
                'options' => [
                    'http' => [
                        'method' => 'POST',
                        'header' => 'Content-type: application/x-www-form-urlencoded',
                        'content' => 'chat_id=123&title=test&object=%7B%7D',
                        'ignore_errors' => true,
                    ],
                ],
            ],
            $request,
        );
    }

    public function testPostWithLocalFiles(): void
    {
        $transport = new NativeTransport();

        StreamMock::enable(
            responseHeaders: [
                'HTTP/1.1 200 OK',
                'Content-Type: text/json',
            ],
            responseBody: '{"ok":true,"result":[]}',
        );

        $response = $transport->send('http://url/sendPhoto', [
            'age' => 19,
            'photo1' => InputFile::fromLocalFile(__DIR__ . '/photo.png'),
            'photo2' => InputFile::fromLocalFile(__DIR__ . '/photo.png', 'face.png'),
        ]);

        $request = StreamMock::disable();

        assertSame(200, $response->statusCode);
        assertSame('{"ok":true,"result":[]}', $response->body);
        assertSame('http://url/sendPhoto', $request['path']);
        assertSame(['http'], array_keys($request['options']));
        assertSame(['method', 'header', 'content', 'ignore_errors'], array_keys($request['options']['http']));
        assertSame('POST', $request['options']['http']['method']);
        assertStringStartsWith('Content-type: multipart/form-data; boundary=', $request['options']['http']['header']);
        assertStringEndsWith('; charset=utf-8', $request['options']['http']['header']);
        assertStringContainsString(file_get_contents(__DIR__ . '/photo.png'), $request['options']['http']['content']);
        assertStringContainsString(
            'Content-Disposition: form-data; name="photo1"; filename="photo.png"',
            $request['options']['http']['content'],
        );
        assertStringContainsString(
            "Content-Disposition: form-data; name=\"age\"\r\n\r\n19",
            $request['options']['http']['content'],
        );
        assertTrue($request['options']['http']['ignore_errors']);
    }
}
