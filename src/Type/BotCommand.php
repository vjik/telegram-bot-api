<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#botcommand
 */
final readonly class BotCommand
{
    public function __construct(
        public string $command,
        public string $description,
    ) {
    }

    public function toRequestArray(): array
    {
        return [
            'command' => $this->command,
            'description' => $this->description,
        ];
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'command'),
            ValueHelper::getString($result, 'description'),
        );
    }
}
