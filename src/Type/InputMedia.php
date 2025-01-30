<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputmedia
 *
 * @api
 */
interface InputMedia
{
    public function getType(): string;

    /**
     * @psalm-return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array;
}
