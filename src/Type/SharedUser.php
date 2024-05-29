<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

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
        public ?string $firstName,
        public ?string $lastName,
        public ?string $username,
        public ?array $photo,
    ) {
    }
}
