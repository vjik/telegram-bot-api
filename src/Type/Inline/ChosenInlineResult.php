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
        public string $query,
        public ?Location $location = null,
        public ?string $inlineMessageId = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'result_id', $raw),
            array_key_exists('from', $result)
                ? User::fromTelegramResult($result['from'], $raw)
                : throw new NotFoundKeyInResultException('from', $raw),
            ValueHelper::getString($result, 'query', $raw),
            array_key_exists('location', $result)
                ? Location::fromTelegramResult($result['location'], $raw)
                : null,
            ValueHelper::getStringOrNull($result, 'inline_message_id', $raw),
        );
    }
}
