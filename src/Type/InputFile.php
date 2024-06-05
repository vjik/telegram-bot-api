<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Psr\Http\Message\StreamInterface;

/**
 * @see https://core.telegram.org/bots/api#sending-files
 */
final readonly class InputFile
{
    /**
     * @param resource|StreamInterface $resource
     */
    public function __construct(
        public mixed $resource,
        public ?string $filename = null,
    ) {
    }

    public static function fromLocalFile(string $path, ?string $filename = null): self
    {
        return new self(fopen($path, 'r'), $filename);
    }
}
