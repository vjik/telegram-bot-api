<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#writeaccessallowed
 */
final readonly class WriteAccessAllowed
{
    public function __construct(
        public ?bool $fromRequest = null,
        public ?string $webAppName = null,
        public ?bool $fromAttachmentMenu = null,
    ) {}
}
