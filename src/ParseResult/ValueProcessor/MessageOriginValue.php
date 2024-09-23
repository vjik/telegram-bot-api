<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\Type\MessageOrigin;
use Vjik\TelegramBot\Api\Type\MessageOriginChannel;
use Vjik\TelegramBot\Api\Type\MessageOriginChat;
use Vjik\TelegramBot\Api\Type\MessageOriginHiddenUser;
use Vjik\TelegramBot\Api\Type\MessageOriginUser;

/**
 * @template-extends InterfaceValue<MessageOrigin>
 */
final readonly class MessageOriginValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'user' => MessageOriginUser::class,
            'hidden_user' => MessageOriginHiddenUser::class,
            'chat' => MessageOriginChat::class,
            'channel' => MessageOriginChannel::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown message origin type.';
    }
}
