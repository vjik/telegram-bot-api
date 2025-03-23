<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport;

use Psr\Http\Message\StreamInterface;
use Vjik\TelegramBot\Api\Type\InputFile;

use function is_resource;

/**
 * @internal
 */
final readonly class FileHelper
{
    public static function read(InputFile $file): string
    {
        return is_resource($file->resource)
            ? self::readResource($file->resource)
            : self::readStream($file->resource);
    }

    public static function basename(InputFile $file): ?string
    {
        if ($file->filename !== null) {
            return basename($file->filename);
        }

        /**
         * @var string $uri
         */
        $uri = is_resource($file->resource)
            ? stream_get_meta_data($file->resource)['uri']
            : $file->resource->getMetadata('uri');

        if (str_contains($uri, '://')) {
            return null;
        }

        return basename($uri);
    }

    /**
     * @param resource $resource
     */
    private static function readResource(mixed $resource): string
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

    private static function readStream(StreamInterface $stream): string
    {
        if ($stream->isSeekable()) {
            $stream->rewind();
        }

        return $stream->getContents();
    }
}
