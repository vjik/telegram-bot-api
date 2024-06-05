<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#writeaccessallowed
 */
final readonly class WriteAccessAllowed
{
    public function __construct(
        public ?bool $fromRequest = null,
        public ?string $webAppName = null,
        public ?bool $fromAttachmentMenu = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getBooleanOrNull($result, 'from_request'),
            ValueHelper::getStringOrNull($result, 'web_app_name'),
            ValueHelper::getBooleanOrNull($result, 'from_attachment_menu'),
        );
    }
}
