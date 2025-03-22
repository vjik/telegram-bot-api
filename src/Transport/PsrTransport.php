<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Vjik\TelegramBot\Api\Type\InputFile;

use function is_scalar;
use function is_string;
use function json_encode;

/**
 * @api
 */
final readonly class PsrTransport implements TransportInterface
{
    public function __construct(
        private ClientInterface $client,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
    ) {}

    public function send(
        string $urlPath,
        array $data = [],
        HttpMethod $httpMethod = HttpMethod::POST,
    ): ApiResponse {
        $response = $this->client->sendRequest(
            match ($httpMethod) {
                HttpMethod::GET => $this->createGetRequest($urlPath, $data),
                HttpMethod::POST => $this->createPostRequest($urlPath, $data),
            },
        );

        $body = $response->getBody();
        if ($body->isSeekable()) {
            $body->rewind();
        }

        return new ApiResponse(
            $response->getStatusCode(),
            $body->getContents(),
        );
    }

    public function downloadFile(string $url): string
    {
        return $this->internalDownload($url)->getContents();
    }

    public function downloadFileTo(string $url, string $savePath): void
    {
        $body = $this->internalDownload($url);

        $content = $body->detach();
        $content ??= $body->getContents();

        set_error_handler(
            static function (int $errorNumber, string $errorString): bool {
                throw new SaveFileException($errorString);
            },
        );
        try {
            file_put_contents($savePath, $content);
        } finally {
            restore_error_handler();
        }
    }

    /**
     * @throws DownloadFileException
     */
    private function internalDownload(string $url): StreamInterface
    {
        $request = $this->requestFactory->createRequest('GET', $url);

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $exception) {
            throw new DownloadFileException($exception->getMessage(), previous: $exception);
        }

        $body = $response->getBody();
        if ($body->isSeekable()) {
            $body->rewind();
        }

        return $body;
    }

    /**
     * @psalm-param array<string, mixed> $data
     */
    private function createPostRequest(string $urlPath, array $data): RequestInterface
    {
        $request = $this->requestFactory->createRequest('POST', $urlPath);

        $files = [];
        foreach ($data as $key => $value) {
            if ($value instanceof InputFile) {
                $files[$key] = $value;
                unset($data[$key]);
            }
        }

        if (empty($data) && empty($files)) {
            return $request;
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

        return $request
            ->withHeader('Content-Length', (string) $body->getSize())
            ->withHeader('Content-Type', $contentType)
            ->withBody($body);
    }

    /**
     * @psalm-param array<string, mixed> $data
     */
    private function createGetRequest(string $urlPath, array $data): RequestInterface
    {
        $queryParameters = [];
        foreach ($data as $key => $value) {
            $queryParameters[$key] = is_scalar($value) ? $value : json_encode($value, JSON_THROW_ON_ERROR);
        }

        $url = $urlPath;
        if (!empty($queryParameters)) {
            $url .= '?' . http_build_query($queryParameters);
        }

        return $this->requestFactory->createRequest('GET', $url);
    }
}
