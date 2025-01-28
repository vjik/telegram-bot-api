<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Transport\PsrTransport\StrictTypeRequest;

use HttpSoft\Message\Response;
use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Vjik\TelegramBot\Api\Transport\PsrTransport;

final class StrictTypeRequestTest extends TestCase
{
    public function testWithHeader(): void
    {
        $streamFactory = new StreamFactory();

        $httpResponse = new Response(201, body: $streamFactory->createStream('hello'));

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($httpResponse);

        $transport = new PsrTransport(
            '04062024',
            $client,
            new StrictTypeRequestFactory(),
            $streamFactory,
        );

        $response = $transport->send('getMyName', ['language_code' => 'ru']);

        $this->assertSame(201, $response->statusCode);
        $this->assertSame('hello', $response->body);
    }
}
