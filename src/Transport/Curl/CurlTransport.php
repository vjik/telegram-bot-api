<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport\Curl;

use CURLStringFile;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use Vjik\TelegramBot\Api\Transport\ApiResponse;
use Vjik\TelegramBot\Api\Transport\ApiUrlGenerator;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Transport\TransportInterface;
use Vjik\TelegramBot\Api\Type\InputFile;

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
        private CurlInterface $curl = new Curl(),
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

        $curl = $this->curl->init();

        try {
            $this->curl->setopt_array($curl, $options);

            /**
             * @var string $body `curl_exec` returns string because `CURLOPT_RETURNTRANSFER` is set to `true`.
             */
            $body = $this->curl->exec($curl);

            $statusCode = $this->curl->getinfo($curl, CURLINFO_HTTP_CODE);
            if (!is_int($statusCode)) {
                $statusCode = 0;
            }
        } finally {
            $this->curl->close($curl);
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

        /**
         * @var string We assume, that `$resource` is correct, so `stream_get_contents` never returns `false`.
         */
        return stream_get_contents($resource);
    }

    private function readStream(StreamInterface $stream): string
    {
        if ($stream->isSeekable()) {
            $stream->rewind();
        }

        return $stream->getContents();
    }
}
