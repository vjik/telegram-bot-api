<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#user
 */
final readonly class User
{
    public function __construct(
        public int $id,
        public bool $isBot,
        public string $firstName,
        public ?string $lastName,
        public ?string $username,
        public ?string $languageCode,
        public ?true $isPremium,
        public ?true $addedToAttachmentMenu,
        public ?bool $canJoinGroups,
        public ?bool $canReadAllGroupMessages,
        public ?bool $supportsInlineQueries,
        public ?bool $canConnectToBusiness,
    ) {
    }
}
