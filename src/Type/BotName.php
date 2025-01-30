<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#botname
 *
 * @api
 */
final readonly class BotName
{
    public function __construct(
        public string $name,
    ) {}
}
