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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'data'),
            ValueHelper::getString($result, 'button_text'),
        );
    }
}
