<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Inline;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\Location;
use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#inlinequery
 */
final readonly class InlineQuery
{
    public function __construct(
        public string $id,
        public User $from,
        public string $query,
        public string $offset,
        public ?string $chatType = null,
        public ?Location $location = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'id'),
            array_key_exists('from', $result)
                ? User::fromTelegramResult($result['from'])
                : throw new NotFoundKeyInResultException('from'),
            ValueHelper::getString($result, 'query'),
            ValueHelper::getString($result, 'offset'),
            ValueHelper::getStringOrNull($result, 'chat_type'),
            array_key_exists('location', $result)
                ? Location::fromTelegramResult($result['location'])
                : null,
        );
    }
}
