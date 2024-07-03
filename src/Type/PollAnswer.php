<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#pollanswer
 */
final readonly class PollAnswer
{
    /**
     * @param int[] $optionIds
     */
    public function __construct(
        public string $pollId,
        public array $optionIds,
        public ?Chat $voterChat = null,
        public ?User $user = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'poll_id', $raw),
            ValueHelper::getArrayOfIntegers($result, 'option_ids', $raw),
            array_key_exists('voter_chat', $result)
                ? Chat::fromTelegramResult($result['voter_chat'], $raw)
                : null,
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'], $raw)
                : null,
        );
    }
}
