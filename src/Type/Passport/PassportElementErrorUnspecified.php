<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Passport;

/**
 * @see https://core.telegram.org/bots/api#passportelementerrorunspecified
 */
final readonly class PassportElementErrorUnspecified implements PassportElementError
{
    public function __construct(
        public string $type,
        public string $elementHash,
        public string $message,
    ) {}

    public function getSource(): string
    {
        return 'unspecified';
    }

    public function toRequestArray(): array
    {
        return [
            'source' => $this->getSource(),
            'type' => $this->type,
            'element_hash' => $this->elementHash,
            'message' => $this->message,
        ];
    }
}
