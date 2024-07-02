<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\Request\RequestFileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputpaidmedia
 */
interface InputPaidMedia
{
    public function getType(): string;

    public function toRequestArray(?RequestFileCollector $fileCollector = null): array;
}
