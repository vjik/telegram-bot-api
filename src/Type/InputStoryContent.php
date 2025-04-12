<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputstorycontent
 *
 * @api
 */
interface InputStoryContent
{
    public function getType(): string;

    /**
     * @psalm-return array<string, mixed>
     */
    public function toRequestArray(FileCollector $fileCollector): array;
}
