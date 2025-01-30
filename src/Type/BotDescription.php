<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#botdescription
 *
 * @api
 */
final readonly class BotDescription
{
    public function __construct(
        public string $description,
    ) {}
}
