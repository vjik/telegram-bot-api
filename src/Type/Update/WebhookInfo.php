<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Update;

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
        public ?string $ipAddress = null,
        public ?DateTimeImmutable $lastErrorDate = null,
        public ?string $lastErrorMessage = null,
        public ?DateTimeImmutable $lastSynchronizationErrorDate = null,
        public ?int $maxConnections = null,
        public ?array $allowedUpdates = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'url', $raw),
            ValueHelper::getBoolean($result, 'has_custom_certificate', $raw),
            ValueHelper::getInteger($result, 'pending_update_count', $raw),
            ValueHelper::getStringOrNull($result, 'ip_address', $raw),
            ValueHelper::getDateTimeImmutableOrNull($result, 'last_error_date', $raw),
            ValueHelper::getStringOrNull($result, 'last_error_message', $raw),
            ValueHelper::getDateTimeImmutableOrNull($result, 'last_synchronization_error_date', $raw),
            ValueHelper::getIntegerOrNull($result, 'max_connections', $raw),
            ValueHelper::getArrayOfStringsOrNull($result, 'allowed_updates', $raw),
        );
    }
}
