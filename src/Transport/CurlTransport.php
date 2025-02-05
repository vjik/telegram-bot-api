<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport;

use CURLStringFile;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use Vjik\TelegramBot\Api\Type\InputFile;

use function curl_close;
use function curl_errno;
use function curl_error;
use function curl_exec;
use function curl_getinfo;
use function curl_init;
use function is_int;
use function is_resource;
use function is_scalar;
use function json_encode;

/**
 * @api
 */
final readonly class CurlTransport implements TransportInterface
{
    private ApiUrlGenerator $apiUrlGenerator;

    public function __construct(
        string $token,
        string $baseUrl = 'https://api.telegram.org',
    ) {
        $this->apiUrlGenerator = new ApiUrlGenerator($token, $baseUrl);
    }

    /**
     * @psalm-param array<string, mixed> $data
     */
    public function send(string $apiMethod, array $data = [], HttpMethod $httpMethod = HttpMethod::POST): ApiResponse
    {
        $options = match ($httpMethod) {
            HttpMethod::GET => $this->createGetOptions($apiMethod, $data),
            HttpMethod::POST => $this->createPostOptions($apiMethod, $data),
        };
        $options[CURLOPT_RETURNTRANSFER] = true;

        $curl = curl_init();
        if ($curl === false) {
            throw new RuntimeException('Failed to initialize CURL.');
        }

        try {
            curl_setopt_array($curl, $options);

            /** @var string|false $body */
            $body = curl_exec($curl);
            if ($body === false) {
                throw new RuntimeException(
                    'CURL error: ' . curl_error($curl),
                    curl_errno($curl),
                );
            }

            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (!is_int($statusCode)) {
                $statusCode = 0;
            }
        } finally {
            curl_close($curl);
        }

        return new ApiResponse($statusCode, $body);
    }

    /**
     * @psalm-param array<string, mixed> $data
     */
    private function createPostOptions(string $apiMethod, array $data): array
    {
        $postFields = [];
        foreach ($data as $key => $value) {
            if (is_scalar($value)) {
                $postFields[$key] = $value;
                continue;
            }

            if ($value instanceof InputFile) {
                $postFields[$key] = new CURLStringFile(
                    is_resource($value->resource)
                        ? $this->readResource($value->resource)
                        : $this->readStream($value->resource),
                    $value->filename ?? '',
                );
                continue;
            }

            $postFields[$key] = json_encode($value, JSON_THROW_ON_ERROR);
        }

        return [
            CURLOPT_POST => true,
            CURLOPT_URL => $this->apiUrlGenerator->generate($apiMethod),
            CURLOPT_POSTFIELDS => $postFields,
        ];
    }

    /**
     * @psalm-param array<string, mixed> $data
     */
    private function createGetOptions(string $apiMethod, array $data): array
    {
        $queryParameters = [];
        foreach ($data as $key => $value) {
            $queryParameters[$key] = is_scalar($value) ? $value : json_encode($value, JSON_THROW_ON_ERROR);
        }

        return [
            CURLOPT_HTTPGET => true,
            CURLOPT_URL => $this->apiUrlGenerator->generate($apiMethod, $queryParameters),
        ];
    }

    /**
     * @param resource $resource
     */
    private function readResource(mixed $resource): string
    {
        $metadata = stream_get_meta_data($resource);
        if ($metadata['seekable']) {
            rewind($resource);
        }

        $data = stream_get_contents($resource);
        if ($data === false) {
            throw new RuntimeException('Could not read resource contents.');
        }

        return $data;
    }

    private function readStream(StreamInterface $stream): string
    {
        if ($stream->isSeekable()) {
            $stream->rewind();
        }

        return $stream->getContents();
    }
}
