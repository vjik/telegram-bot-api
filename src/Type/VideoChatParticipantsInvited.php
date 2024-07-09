<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#videochatparticipantsinvited
 */
final readonly class VideoChatParticipantsInvited
{
    /**
     * @param User[] $users
     */
    public function __construct(
        #[ArrayOfObjectsValue(User::class)]
        public array $users,
    ) {}
}
