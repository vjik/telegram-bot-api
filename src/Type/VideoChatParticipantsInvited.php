<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#videochatparticipantsinvited
 */
final readonly class VideoChatParticipantsInvited
{
    /**
     * @param User[] $users
     */
    public function __construct(
        public array $users,
    ) {
    }
}
