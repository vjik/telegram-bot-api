<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#webappinfo
 *
 * @api
 */
final readonly class WebAppInfo
{
    public function __construct(
        public string $url,
    ) {}

    public function toRequestArray(): array
    {
        return [
            'url' => $this->url,
        ];
    }
}
