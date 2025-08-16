<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#directmessagestopic
 *
 * @api
 */
final readonly class DirectMessagesTopic
{
    public function __construct(
        public int $topicId,
        public ?User $user = null,
    ) {}
}
