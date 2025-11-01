<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\NativeTransport;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use stdClass;
use Phptg\BotApi\Tests\Transport\NativeTransport\StreamMock\StreamMock;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Transport\MimeTypeResolver\MimeTypeResolverInterface;
use Phptg\BotApi\Transport\NativeTransport;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertMatchesRegularExpression;
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
        assertMatchesRegularExpression(
            '~^Content-type: multipart/form-data; boundary=[\da-f]+\.[\da-f]+; charset=utf-8$~',
            $request['options']['http']['header'],
        );
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

    public function testPostWithStreamFile(): void
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
            'file1' => new InputFile(
                (new StreamFactory())->createStream('test1'),
            ),
            'file2' => new InputFile(
                (new StreamFactory())->createStream('test2'),
                'test.txt',
            ),
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
        assertStringContainsString('test2', $request['options']['http']['content']);
        assertStringContainsString(
            "Content-Disposition: form-data; name=\"file1\"\r\n"
            . "\r\n"
            . "test1\r\n",
            $request['options']['http']['content'],
        );
        assertStringContainsString(
            "Content-Disposition: form-data; name=\"file2\"; filename=\"test.txt\"\r\n"
            . "Content-Type: text/plain\r\n"
            . "\r\n"
            . "test2\r\n",
            $request['options']['http']['content'],
        );
        assertTrue($request['options']['http']['ignore_errors']);
    }

    public function testPostWithFileAndArray(): void
    {
        $transport = new NativeTransport();

        StreamMock::enable(
            responseHeaders: [
                'HTTP/1.1 200 OK',
                'Content-Type: text/json',
            ],
            responseBody: '{"ok":true,"result":[]}',
        );

        $transport->send('http://url/method', [
            'file1' => new InputFile(
                (new StreamFactory())->createStream('test1'),
            ),
            'ages' => [23, 45],
        ]);

        $request = StreamMock::disable();

        assertTrue(isset($request['options']['http']['content']));
        assertStringContainsString(
            "Content-Disposition: form-data; name=\"ages\"\r\n"
            . "\r\n"
            . "[23,45]\r\n",
            $request['options']['http']['content'],
        );
        assertStringContainsString(
            "Content-Disposition: form-data; name=\"file1\"\r\n"
            . "\r\n"
            . "test1\r\n",
            $request['options']['http']['content'],
        );
    }

    public function testCustomMimeTypeResolver(): void
    {
        $transport = new NativeTransport(
            new class implements MimeTypeResolverInterface {
                public function resolve(InputFile $file): ?string
                {
                    return 'text/custom';
                }
            },
        );

        StreamMock::enable(
            responseHeaders: [
                'HTTP/1.1 200 OK',
                'Content-Type: text/json',
            ],
            responseBody: '{"ok":true,"result":[]}',
        );

        $transport->send('http://url/method', [
            'file1' => new InputFile(
                (new StreamFactory())->createStream('test1'),
            ),
        ]);

        $request = StreamMock::disable();

        assertTrue(isset($request['options']['http']['content']));
        assertStringContainsString(
            "Content-Disposition: form-data; name=\"file1\"\r\n"
            . "Content-Type: text/custom\r\n"
            . "\r\n"
            . "test1\r\n",
            $request['options']['http']['content'],
        );
    }

    public function testErrorOnSend(): void
    {
        $transport = new NativeTransport();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('file_get_contents(): Unable to find the wrapper "example"');
        $transport->send('example://url/logOut');
    }

    public function testWithoutCode(): void
    {
        $transport = new NativeTransport();

        StreamMock::enable(
            responseHeaders: [
                'Content-Type: text/json',
            ],
            responseBody: '{"ok":true,"result":[]}',
        );

        $response = $transport->send('http://url/logOut');

        StreamMock::disable();

        assertSame(0, $response->statusCode);
    }
}
