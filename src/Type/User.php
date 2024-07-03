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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getInteger($result, 'id', $raw),
            ValueHelper::getBoolean($result, 'is_bot', $raw),
            ValueHelper::getString($result, 'first_name', $raw),
            ValueHelper::getStringOrNull($result, 'last_name', $raw),
            ValueHelper::getStringOrNull($result, 'username', $raw),
            ValueHelper::getStringOrNull($result, 'language_code', $raw),
            ValueHelper::getTrueOrNull($result, 'is_premium', $raw),
            ValueHelper::getTrueOrNull($result, 'added_to_attachment_menu', $raw),
            ValueHelper::getBooleanOrNull($result, 'can_join_groups', $raw),
            ValueHelper::getBooleanOrNull($result, 'can_read_all_group_messages', $raw),
            ValueHelper::getBooleanOrNull($result, 'supports_inline_queries', $raw),
            ValueHelper::getBooleanOrNull($result, 'can_connect_to_business', $raw),
        );
    }
}
