<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getInteger($result, 'id'),
            ValueHelper::getBoolean($result, 'is_bot'),
            ValueHelper::getString($result, 'first_name'),
            ValueHelper::getStringOrNull($result, 'last_name'),
            ValueHelper::getStringOrNull($result, 'username'),
            ValueHelper::getStringOrNull($result, 'language_code'),
            ValueHelper::getTrueOrNull($result, 'is_premium'),
            ValueHelper::getTrueOrNull($result, 'added_to_attachment_menu'),
            ValueHelper::getBooleanOrNull($result, 'can_join_groups'),
            ValueHelper::getBooleanOrNull($result, 'can_read_all_group_messages'),
            ValueHelper::getBooleanOrNull($result, 'supports_inline_queries'),
            ValueHelper::getBooleanOrNull($result, 'can_connect_to_business'),
        );
    }
}
