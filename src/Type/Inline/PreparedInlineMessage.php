<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Inline;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#preparedinlinemessage
 *
 * @api
 */
final readonly class PreparedInlineMessage
{
    public function __construct(
        public string $id,
        public DateTimeImmutable $expirationDate,
    ) {}
}
