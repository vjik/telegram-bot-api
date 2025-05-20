<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport;

use RuntimeException;
use Vjik\TelegramBot\Api\Transport\MimeTypeResolver\ApacheMimeTypeResolver;
use Vjik\TelegramBot\Api\Transport\MimeTypeResolver\MimeTypeResolverInterface;
use Vjik\TelegramBot\Api\Type\InputFile;

use function is_scalar;
use function is_string;
use function json_encode;

/**
 * @see https://www.php.net/manual/function.file-get-contents.php
 * @see https://www.php.net/manual/function.file-put-contents.php
 *
 * @api
 */
final readonly class NativeTransport implements TransportInterface
{
    private MimeTypeResolverInterface $mimeTypeResolver;

    public function __construct(
        ?MimeTypeResolverInterface $mimeTypeResolver = null,
    ) {
        $this->mimeTypeResolver = $mimeTypeResolver ?? new ApacheMimeTypeResolver();
    }

    public function send(string $urlPath, array $data = [], HttpMethod $httpMethod = HttpMethod::POST): ApiResponse
    {
        global $http_response_header;

        [$url, $options] = match ($httpMethod) {
            HttpMethod::GET => $this->createGetRequest($urlPath, $data),
            HttpMethod::POST => $this->createPostRequest($urlPath, $data),
        };
        $options['ignore_errors'] = true;

        $context = stream_context_create(['http' => $options]);

        set_error_handler(
            static function (int $errorNumber, string $errorString): bool {
                throw new RuntimeException($errorString);
            },
        );
        try {
            /**
             * @var string $body We throw exception on error, so `file_get_contents()` returns string.
             */
            $body = file_get_contents($url, context: $context);
        } finally {
            restore_error_handler();
        }

        /**
         * @psalm-var non-empty-list<string> $http_response_header
         * @see https://www.php.net/manual/reserved.variables.httpresponseheader.php
         */

        return new ApiResponse(
            $this->parseStatusCode($http_response_header),
            $body,
        );
    }

    public function downloadFile(string $url): string
    {
        set_error_handler(
            static function (int $errorNumber, string $errorString): bool {
                throw new DownloadFileException($errorString);
            },
        );
        try {
            /**
             * @var string We throw exception on error, so `file_get_contents()` returns string.
             */
            return file_get_contents($url);
        } finally {
            restore_error_handler();
        }
    }

    public function downloadFileTo(string $url, string $savePath): void
    {
        $content = $this->downloadFile($url);

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
     * @psalm-param array<string, mixed> $data
     * @psalm-return list{string, array}
     */
    private function createGetRequest(string $urlPath, array $data): array
    {
        $queryParameters = array_map(
            static fn($value) => is_scalar($value) ? $value : json_encode($value, JSON_THROW_ON_ERROR),
            $data,
        );

        $url = $urlPath;
        if (!empty($queryParameters)) {
            $url .= '?' . http_build_query($queryParameters);
        }

        return [
            $url,
            ['method' => 'GET'],
        ];
    }

    /**
     * @psalm-param array<string, mixed> $data
     * @psalm-return list{string, array}
     */
    private function createPostRequest(string $urlPath, array $data): array
    {
        $files = [];
        foreach ($data as $key => $value) {
            if ($value instanceof InputFile) {
                $files[$key] = $value;
                unset($data[$key]);
            }
        }

        if (empty($files)) {
            $fields = array_map(
                static fn($value) => is_scalar($value) ? $value : json_encode($value, JSON_THROW_ON_ERROR),
                $data,
            );
            $content = http_build_query($fields);
            $contentType = 'application/x-www-form-urlencoded';
        } else {
            $boundary = uniqid('', true);
            $content = $this->buildMultipartFormData($data, $files, $boundary);
            $contentType = 'multipart/form-data; boundary=' . $boundary . '; charset=utf-8';
        }

        return [
            $urlPath,
            [
                'method' => 'POST',
                'header' => 'Content-type: ' . $contentType,
                'content' => $content,
            ],
        ];
    }

    /**
     * @psalm-param array<string, mixed> $data
     * @psalm-param array<string, InputFile> $files
     */
    private function buildMultipartFormData(array $data, array $files, string $boundary): string
    {
        $result = [];

        foreach ($data as $key => $value) {
            $result[] = "--$boundary";
            $result[] = "Content-Disposition: form-data; name=\"$key\"";
            $result[] = '';
            $result[] = is_string($value) ? $value : json_encode($value, JSON_THROW_ON_ERROR);
        }

        foreach ($files as $key => $file) {
            $mimeType = $this->mimeTypeResolver->resolve($file);
            $filename = FileHelper::basename($file);

            $contentDisposition = "Content-Disposition: form-data; name=\"$key\"";
            if ($filename !== null) {
                $contentDisposition .= "; filename=\"$filename\"";
            }

            $result[] = "--$boundary";
            $result[] = $contentDisposition;
            if ($mimeType !== null) {
                $result[] = "Content-Type: $mimeType";
            }
            $result[] = '';
            $result[] = FileHelper::read($file);
        }

        $result[] = "--$boundary--";
        $result[] = '';

        return implode("\r\n", $result);
    }

    /**
     * @psalm-param non-empty-list<string> $headers
     */
    private function parseStatusCode(array $headers): int
    {
        return preg_match('/HTTP\/\d+\.\d+ (\d+)/', $headers[0], $matches)
            ? (int) $matches[1]
            : 0;
    }
}
