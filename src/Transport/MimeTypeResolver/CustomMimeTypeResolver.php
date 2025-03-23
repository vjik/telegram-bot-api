<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport\MimeTypeResolver;

use Vjik\TelegramBot\Api\Type\InputFile;

final readonly class CustomMimeTypeResolver implements MimeTypeResolverInterface
{
    /**
     * @psalm-param array<lowercase-string, string> $map
     */
    public function __construct(
        private array $map,
    ) {
    }

    public function resolve(InputFile $file): ?string
    {
        if ($file->filename === null) {
            return null;
        }

        $extension = strtolower(
            pathinfo($file->filename, PATHINFO_EXTENSION),
        );

        return $this->map[$extension] ?? null;
    }
}
