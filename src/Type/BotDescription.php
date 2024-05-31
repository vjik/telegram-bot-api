<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#botdescription
 */
final readonly class BotDescription
{
    public function __construct(
        public string $description,
    ) {
    }

    public static function fromTelegramResult(array $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'description'),
        );
    }
}
