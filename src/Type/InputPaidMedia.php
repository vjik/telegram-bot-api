<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputpaidmedia
 *
 * @api
 */
interface InputPaidMedia
{
    public function getType(): string;

    public function toRequestArray(?FileCollector $fileCollector = null): array;
}
