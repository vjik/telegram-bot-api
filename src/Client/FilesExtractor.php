<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Client;

use Vjik\TelegramBot\Api\Type\InputFile;

final class FilesExtractor
{
    /**
     * @psalm-return array<array-key,InputFile|array<array-key,InputFile>>
     */
    public function extract(array &$data): array
    {
        $files = [];
        $this->extractInternal($data, $files);
        return $files;
    }

    /**
     * @psalm-param-out array<array-key,InputFile|array<array-key,InputFile>> $files
     * @psalm-suppress ReferenceConstraintViolation Because Psalm don't support recursion
     */
    private function extractInternal(array &$data, array &$files): void
    {
        foreach ($data as $key => $value) {
            if ($value instanceof InputFile) {
                $files[$key] = $value;
                unset($data[$key]);
                continue;
            }

            if (is_array($value)) {
                $internalFiles = [];
                $this->extractInternal($value, $internalFiles);
                if (!empty($internalFiles)) {
                    $files[$key] = $internalFiles;
                    if (empty($value)) {
                        unset($data[$key]);
                    } else {
                        $data[$key] = $value;
                    }
                }
            }
        }
    }
}
