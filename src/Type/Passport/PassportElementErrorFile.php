<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Passport;

/**
 * @see https://core.telegram.org/bots/api#passportelementerrorfile
 */
final readonly class PassportElementErrorFile implements PassportElementError
{
    public function __construct(
        public string $type,
        public string $fileHash,
        public string $message,
    ) {}

    public function getSource(): string
    {
        return 'file';
    }

    public function toRequestArray(): array
    {
        return [
            'source' => $this->getSource(),
            'type' => $this->type,
            'file_hash' => $this->fileHash,
            'message' => $this->message,
        ];
    }
}
