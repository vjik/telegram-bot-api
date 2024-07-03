<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#webappdata
 */
final readonly class WebAppData
{
    public function __construct(
        public string $data,
        public string $buttonText,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'data', $raw),
            ValueHelper::getString($result, 'button_text', $raw),
        );
    }
}
