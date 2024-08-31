<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Client;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;

final readonly class PsrTelegramClient implements TelegramClientInterface
{
    private HttpAdapter $httpAdapter;
    public function __construct(
        string $token,
        private ClientInterface $httpClient,
        RequestFactoryInterface $httpRequestFactory,
        StreamFactoryInterface $streamFactory,
        string $baseUrl = 'https://api.telegram.org',
    ) {
        $this->httpAdapter = new HttpAdapter(
            $httpRequestFactory,
            $streamFactory,
            new ApiUrlGenerator($token, $baseUrl),
        );
    }

    public function send(TelegramRequestInterface $request): TelegramResponse
    {
        $httpResponse = $this->httpClient->sendRequest(
            $this->httpAdapter->toHttpRequest($request),
        );

        return new TelegramResponse(
            $httpResponse->getStatusCode(),
            $httpResponse->getBody()->getContents(),
        );
    }
}
