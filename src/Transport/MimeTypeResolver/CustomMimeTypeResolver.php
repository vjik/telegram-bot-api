<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport\MimeTypeResolver;

use Vjik\TelegramBot\Api\Transport\FileHelper;
use Vjik\TelegramBot\Api\Type\InputFile;

/**
 * @api
 */
final readonly class CustomMimeTypeResolver implements MimeTypeResolverInterface
{
    /**
     * @psalm-param array<lowercase-string, string> $map
     */
    public function __construct(
        private array $map,
    ) {}

    public function resolve(InputFile $file): ?string
    {
        $extension = FileHelper::extension($file);
        if ($extension === null) {
            return null;
        }

        return $this->map[strtolower($extension)] ?? null;
    }
}
