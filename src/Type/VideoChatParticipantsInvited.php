<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getArrayOfUsers($result, 'users'),
        );
    }
}
