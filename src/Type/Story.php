<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#story
 */
final readonly class Story
{
    public function __construct(
        public Chat $chat,
        public int $id,
    ) {
    }
}
