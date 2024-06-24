<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\Request\RequestFileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputmedia
 */
interface InputMedia
{
    public function getType(): string;

    /**
     * @psalm-return array<string, mixed>
     */
    public function toRequestArray(?RequestFileCollector $fileCollector = null): array;
}
