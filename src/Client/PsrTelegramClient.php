<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Client;

use JsonException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface as HttpRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\TelegramRuntimeException;

final readonly class PsrTelegramClient implements TelegramClientInterface
{
    private ApiUrlGenerator $apiUrlGenerator;

    public function __construct(
        private string $token,
        private ClientInterface $httpClient,
        private RequestFactoryInterface $httpRequestFactory,
        private StreamFactoryInterface $streamFactory,
        private string $baseUrl = 'https://api.telegram.org',
    ) {
        $this->apiUrlGenerator = new ApiUrlGenerator($this->token, $this->baseUrl);
    }

    public function send(TelegramRequestInterface $request): array
    {
        $httpRequest = $this->createHttpRequest($request);

        $httpResponse = $this->httpClient->sendRequest($httpRequest);
        if ($httpResponse->getStatusCode() !== 200) {
            throw new TelegramRuntimeException(
                'Failed telegram request. Response code: ' . $httpResponse->getStatusCode() . '.'
            );
        }

        try {
            $decodedResponse = json_decode($httpResponse->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new TelegramRuntimeException('Failed to decode JSON response.', previous: $e);
        }

        if (!is_array($decodedResponse)) {
            throw new TelegramRuntimeException(
                'Expected telegram response as array. Got ' . get_debug_type($decodedResponse) . '.'
            );
        }

        return $decodedResponse;
    }

    private function createHttpRequest(TelegramRequestInterface $request): HttpRequestInterface
    {
        $httpMethod = $request->getHttpMethod();

        $httpRequest = $this->httpRequestFactory->createRequest(
            $httpMethod->value,
            $this->apiUrlGenerator->generate($request->getApiMethod()),
        );

        if ($httpMethod === HttpMethod::POST) {
            $data = $request->getData();
            if (!empty($data)) {
                $content = json_encode($data, JSON_THROW_ON_ERROR);
                $body = $this->streamFactory->createStream($content);
                $httpRequest = $httpRequest
                    ->withHeader('Content-Length', (string) $body->getSize())
                    ->withHeader('Content-Type', 'application/json; charset=utf-8')
                    ->withBody($body);
            }
        }

        return $httpRequest;
    }
}
