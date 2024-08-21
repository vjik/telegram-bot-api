<?php

namespace Vjik\TelegramBot\Api\Client;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Type\InputFile;

final readonly class HttpAdapter
{
    public function __construct(
        private RequestFactoryInterface $httpRequestFactory,
        private StreamFactoryInterface $streamFactory,
        private ApiUrlGenerator $apiUrlGenerator,
    ) {}

    public function toHttpRequest(TelegramRequestInterface $telegramRequest): RequestInterface
    {
        return match ($telegramRequest->getHttpMethod()) {
            HttpMethod::GET => $this->createGetRequest($telegramRequest),
            HttpMethod::POST => $this->createPostRequest($telegramRequest),
        };
    }

    private function createPostRequest(TelegramRequestInterface $request): RequestInterface
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

    private function createGetRequest(TelegramRequestInterface $request): RequestInterface
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
