<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#webappdata
 *
 * @api
 */
final readonly class WebAppData
{
    public function __construct(
        public string $data,
        public string $buttonText,
    ) {}
}
