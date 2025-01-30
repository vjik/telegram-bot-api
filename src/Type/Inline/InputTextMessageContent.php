<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Inline;

use Vjik\TelegramBot\Api\Type\LinkPreviewOptions;
use Vjik\TelegramBot\Api\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#inputtextmessagecontent
 *
 * @api
 */
final readonly class InputTextMessageContent implements InputMessageContent
{
    /**
     * @param MessageEntity[]|null $entities
     */
    public function __construct(
        public string $messageText,
        public ?string $parseMode = null,
        public ?array $entities = null,
        public ?LinkPreviewOptions $linkPreviewOptions = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'message_text' => $this->messageText,
                'parse_mode' => $this->parseMode,
                'entities' => $this->entities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->entities,
                ),
                'link_preview_options' => $this->linkPreviewOptions?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
