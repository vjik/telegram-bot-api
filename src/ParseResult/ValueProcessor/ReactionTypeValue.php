<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\Type\ReactionTypeCustomEmoji;
use Vjik\TelegramBot\Api\Type\ReactionTypeEmoji;

final readonly class ReactionTypeValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'emoji' => ReactionTypeEmoji::class,
            'custom_emoji' => ReactionTypeCustomEmoji::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown reaction type.';
    }
}
