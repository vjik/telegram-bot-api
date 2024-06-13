<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#inputpolloption
 */
final readonly class InputPollOption
{
    /**
     * @param MessageEntity[]|null $textEntities
     */
    public function __construct(
        public ?string $text = null,
        public ?string $textParseMode = null,
        public ?array $textEntities = null,
    ) {
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'text' => $this->text,
                'parse_mode' => $this->textParseMode,
                'entities' => $this->textEntities === null
                    ? null
                    : array_map(
                        static fn(MessageEntity $entity) => $entity->toRequestArray(),
                        $this->textEntities
                    ),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
