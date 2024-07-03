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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getArrayOfUsers($result, 'users', $raw),
        );
    }
}
