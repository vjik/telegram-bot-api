<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chat
 */
final readonly class Chat
{
    public function __construct(
        public int $id,
        public string $type,
        public ?string $title = null,
        public ?string $username = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?true $isForum = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getInteger($result, 'id', $raw),
            ValueHelper::getString($result, 'type', $raw),
            ValueHelper::getStringOrNull($result, 'title', $raw),
            ValueHelper::getStringOrNull($result, 'username', $raw),
            ValueHelper::getStringOrNull($result, 'first_name', $raw),
            ValueHelper::getStringOrNull($result, 'last_name', $raw),
            ValueHelper::getTrueOrNull($result, 'is_forum', $raw),
        );
    }
}
