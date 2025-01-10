<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\InputFileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputpaidmedia
 */
interface InputPaidMedia
{
    public function getType(): string;

    public function toRequestArray(?InputFileCollector $fileCollector = null): array;
}
