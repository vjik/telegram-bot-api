<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Request;

use Vjik\TelegramBot\Api\Type\InputFile;

interface TelegramRequestWithFilesInterface extends TelegramRequestInterface
{
    /**
     * @return InputFile[]
     * @psalm-return array<string,InputFile>
     */
    public function getFiles(): array;
}
