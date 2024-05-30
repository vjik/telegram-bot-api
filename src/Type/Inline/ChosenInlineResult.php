<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Inline;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\Location;
use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#choseninlineresult
 */
final readonly class ChosenInlineResult
{
    public function __construct(
        public string $resultId,
        public User $from,
        public ?Location $location,
        public ?string $inlineMessageId,
        public string $query,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'result_id'),
            array_key_exists('from', $result)
                ? User::fromTelegramResult($result['from'])
                : throw new NotFoundKeyInResultException('from'),
            array_key_exists('location', $result)
                ? Location::fromTelegramResult($result['location'])
                : null,
            ValueHelper::getStringOrNull($result, 'inline_message_id'),
            ValueHelper::getString($result, 'query'),
        );
    }
}
