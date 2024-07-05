<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#chatbackground
 */
final readonly class ChatBackground
{
    public function __construct(
        public BackgroundType $type,
    ) {
    }
}
