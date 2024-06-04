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
        public ?string $lastName = null,
        public ?string $username = null,
        public ?string $languageCode = null,
        public ?true $isPremium = null,
        public ?true $addedToAttachmentMenu = null,
        public ?bool $canJoinGroups = null,
        public ?bool $canReadAllGroupMessages = null,
        public ?bool $supportsInlineQueries = null,
        public ?bool $canConnectToBusiness = null,
    ) {
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'id' => $this->id,
                'is_bot' => $this->isBot,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'username' => $this->username,
                'language_code' => $this->languageCode,
                'is_premium' => $this->isPremium,
                'added_to_attachment_menu' => $this->addedToAttachmentMenu,
                'can_join_groups' => $this->canJoinGroups,
                'can_read_all_group_messages' => $this->canReadAllGroupMessages,
                'supports_inline_queries' => $this->supportsInlineQueries,
                'can_connect_to_business' => $this->canConnectToBusiness,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
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
