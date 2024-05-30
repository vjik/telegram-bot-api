<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Update;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#webhookinfo
 */
final readonly class WebhookInfo
{
    /**
     * @param string[]|null $allowedUpdates
     */
    public function __construct(
        public string $url,
        public bool $hasCustomCertificate,
        public int $pendingUpdateCount,
        public ?string $ipAddress,
        public ?DateTimeImmutable $lastErrorDate,
        public ?string $lastErrorMessage,
        public ?DateTimeImmutable $lastSynchronizationErrorDate,
        public ?int $maxConnections,
        public ?array $allowedUpdates,
    ) {
    }

    public static function fromTelegramResult(array $result): self
    {
        return new self(
            ValueHelper::getString($result, 'url'),
            ValueHelper::getBoolean($result, 'has_custom_certificate'),
            ValueHelper::getInteger($result, 'pending_update_count'),
            ValueHelper::getStringOrNull($result, 'ip_address'),
            ValueHelper::getDateTimeImmutableOrNull($result, 'last_error_date'),
            ValueHelper::getStringOrNull($result, 'last_error_message'),
            ValueHelper::getDateTimeImmutableOrNull($result, 'last_synchronization_error_date'),
            ValueHelper::getIntegerOrNull($result, 'max_connections'),
            ValueHelper::getArrayOfStringsOrNull($result, 'allowed_updates'),
        );
    }
}
