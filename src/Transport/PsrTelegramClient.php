<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface as HttpRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Type\InputFile;

use function is_string;

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

    public function send(TelegramRequestInterface $request): TelegramResponse
    {
        $httpResponse = $this->httpClient->sendRequest(
            match ($request->getHttpMethod()) {
                HttpMethod::GET => $this->createGetRequest($request),
                HttpMethod::POST => $this->createPostRequest($request),
            },
        );

        $body = $httpResponse->getBody();
        if ($body->isSeekable()) {
            $body->rewind();
        }

        return new TelegramResponse(
            $httpResponse->getStatusCode(),
            $body->getContents(),
        );
    }

    private function createPostRequest(TelegramRequestInterface $request): HttpRequestInterface
    {
        $httpRequest = $this->httpRequestFactory->createRequest(
            'POST',
            $this->apiUrlGenerator->generate($request->getApiMethod()),
        );

        $data = $request->getData();

        $files = [];
        foreach ($data as $key => $value) {
            if ($value instanceof InputFile) {
                $files[$key] = $value;
                unset($data[$key]);
            }
        }

        if (empty($data) && empty($files)) {
            return $httpRequest;
        }
        if (empty($files)) {
            $content = json_encode($data, JSON_THROW_ON_ERROR);
            $body = $this->streamFactory->createStream($content);
            $contentType = 'application/json; charset=utf-8';
        } else {
            $streamBuilder = new MultipartStreamBuilder($this->streamFactory);
            foreach ($data as $key => $value) {
                $streamBuilder->addResource(
                    $key,
                    is_string($value) ? $value : json_encode($value, JSON_THROW_ON_ERROR),
                );
            }
            foreach ($files as $key => $file) {
                $streamBuilder->addResource(
                    $key,
                    $file->resource,
                    $file->filename === null ? [] : ['filename' => $file->filename],
                );
            }
            $body = $streamBuilder->build();
            $contentType = 'multipart/form-data; boundary=' . $streamBuilder->getBoundary() . '; charset=utf-8';
        }

        return $httpRequest
            ->withHeader('Content-Length', (string) $body->getSize())
            ->withHeader('Content-Type', $contentType)
            ->withBody($body);
    }

    private function createGetRequest(TelegramRequestInterface $request): HttpRequestInterface
    {
        $queryParameters = [];
        foreach ($request->getData() as $key => $value) {
            $queryParameters[$key] = is_scalar($value) ? $value : json_encode($value, JSON_THROW_ON_ERROR);
        }

        return $this->httpRequestFactory->createRequest(
            'GET',
            $this->apiUrlGenerator->generate($request->getApiMethod(), $queryParameters),
        );
    }
}
