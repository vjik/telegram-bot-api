<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\Type\ReactionType;
use Vjik\TelegramBot\Api\Type\ReactionTypeCustomEmoji;
use Vjik\TelegramBot\Api\Type\ReactionTypeEmoji;
use Vjik\TelegramBot\Api\Type\ReactionTypePaid;

/**
 * @template-extends InterfaceValue<ReactionType>
 */
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
            'paid' => ReactionTypePaid::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown reaction type.';
    }
}
