<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#webappinfo
 */
final readonly class WebAppInfo
{
    public function __construct(
        public string $url,
    ) {
    }

    public function toRequestArray(): array
    {
        return [
            'url' => $this->url,
        ];
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'url', $raw),
        );
    }
}
