<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Passport;

/**
 * @see https://core.telegram.org/bots/api#passportelementerror
 *
 * @api
 */
interface PassportElementError
{
    public function getSource(): string;

    public function toRequestArray(): array;
}
