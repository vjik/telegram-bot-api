<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#shareduser
 */
final readonly class SharedUser
{
    /**
     * @param PhotoSize[]|null $photo
     */
    public function __construct(
        public int $userId,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $username = null,
        public ?array $photo = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getInteger($result, 'user_id'),
            ValueHelper::getStringOrNull($result, 'first_name'),
            ValueHelper::getStringOrNull($result, 'last_name'),
            ValueHelper::getStringOrNull($result, 'username'),
            ValueHelper::getArrayOfPhotoSizesOrNull($result, 'photo'),
        );
    }
}
