<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Update;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayMap;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\StringValue;

/**
 * @see https://core.telegram.org/bots/api#webhookinfo
 *
 * @api
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
        #[ArrayMap(StringValue::class)]
        public ?array $allowedUpdates = null,
    ) {}
}
