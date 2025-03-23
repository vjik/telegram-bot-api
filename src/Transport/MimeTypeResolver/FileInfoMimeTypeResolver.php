<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport\MimeTypeResolver;

use Vjik\TelegramBot\Api\Type\InputFile;

use function extension_loaded;
use function is_resource;

final readonly class FileInfoMimeTypeResolver implements MimeTypeResolverInterface
{
    public function resolve(InputFile $file): ?string
    {
        if (!extension_loaded('fileinfo')) {
            return null;
        }

        /**
         * @var resource|string $normalizedFile
         */
        $normalizedFile = is_resource($file->resource)
            ? $file->resource
            : $file->resource->getMetadata('uri');

        $result = mime_content_type($normalizedFile);
        return $result === false ? null : $result;
    }
}
