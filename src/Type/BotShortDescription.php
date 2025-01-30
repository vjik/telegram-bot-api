<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#botshortdescription
 *
 * @api
 */
final readonly class BotShortDescription
{
    public function __construct(
        public string $shortDescription,
    ) {}
}
