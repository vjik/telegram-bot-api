<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Request;

use Vjik\TelegramBot\Api\Type\InputFile;

final class RequestFileCollector
{
    private int $counter;

    /**
     * @psalm-var array<string,InputFile>
     */
    private array $files = [];

    public function __construct(
        private string $prefix = 'file',
        int $start = 0,
    ) {
        $this->counter = $start;
    }

    public function add(InputFile $file): string
    {
        $key = $this->prefix . $this->counter++;
        $this->files[$key] = $file;
        return $key;
    }

    /**
     * @psalm-return array<string,InputFile>
     */
    public function get(): array
    {
        return $this->files;
    }
}
