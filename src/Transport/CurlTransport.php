<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport;

use CURLStringFile;
use Vjik\TelegramBot\Api\Curl\Curl;
use Vjik\TelegramBot\Api\Curl\CurlException;
use Vjik\TelegramBot\Api\Curl\CurlInterface;
use Vjik\TelegramBot\Api\Type\InputFile;

use function is_int;
use function is_scalar;
use function json_encode;

/**
 * @api
 */
final readonly class CurlTransport implements TransportInterface
{
    public function __construct(
        private CurlInterface $curl = new Curl(),
    ) {}

    /**
     * @psalm-param array<string, mixed> $data
     */
    public function send(string $urlPath, array $data = [], HttpMethod $httpMethod = HttpMethod::POST): ApiResponse
    {
        $options = match ($httpMethod) {
            HttpMethod::GET => $this->createGetOptions($urlPath, $data),
            HttpMethod::POST => $this->createPostOptions($urlPath, $data),
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

    public function downloadFile(string $url): string
    {
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR => true,
        ];

        try {
            $curl = $this->curl->init();
        } catch (CurlException $exception) {
            throw new DownloadFileException($exception->getMessage(), previous: $exception);
        }

        try {
            $this->curl->setopt_array($curl, $options);

            /**
             * @var string $result `curl_exec` returns string because `CURLOPT_RETURNTRANSFER` is set to `true`.
             */
            $result = $this->curl->exec($curl);
        } catch (CurlException $exception) {
            throw new DownloadFileException($exception->getMessage(), previous: $exception);
        } finally {
            $this->curl->close($curl);
        }

        return $result;
    }

    public function downloadFileTo(string $url, string $savePath): void
    {
        set_error_handler(
            static function (int $errorNumber, string $errorString): bool {
                throw new SaveFileException($errorString);
            },
        );
        try {
            $fileHandler = fopen($savePath, 'wb');
        } finally {
            restore_error_handler();
        }

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_FILE => $fileHandler,
            CURLOPT_FAILONERROR => true,
        ];

        try {
            $curl = $this->curl->init();
        } catch (CurlException $exception) {
            throw new DownloadFileException($exception->getMessage(), previous: $exception);
        }

        try {
            $this->curl->setopt_array($curl, $options);
            $this->curl->exec($curl);
        } catch (CurlException $exception) {
            throw new DownloadFileException($exception->getMessage(), previous: $exception);
        } finally {
            $this->curl->close($curl);
        }
    }

    /**
     * @psalm-param array<string, mixed> $data
     */
    private function createPostOptions(string $urlPath, array $data): array
    {
        $postFields = [];
        foreach ($data as $key => $value) {
            if (is_scalar($value)) {
                $postFields[$key] = $value;
                continue;
            }

            if ($value instanceof InputFile) {
                $postFields[$key] = new CURLStringFile(
                    FileHelper::read($value),
                    $value->filename ?? '',
                );
                continue;
            }

            $postFields[$key] = json_encode($value, JSON_THROW_ON_ERROR);
        }

        return [
            CURLOPT_POST => true,
            CURLOPT_URL => $urlPath,
            CURLOPT_POSTFIELDS => $postFields,
        ];
    }

    /**
     * @psalm-param array<string, mixed> $data
     */
    private function createGetOptions(string $urlPath, array $data): array
    {
        $queryParameters = [];
        foreach ($data as $key => $value) {
            $queryParameters[$key] = is_scalar($value) ? $value : json_encode($value, JSON_THROW_ON_ERROR);
        }

        $url = $urlPath;
        if (!empty($queryParameters)) {
            $url .= '?' . http_build_query($queryParameters);
        }

        return [
            CURLOPT_HTTPGET => true,
            CURLOPT_URL => $url,
        ];
    }
}
