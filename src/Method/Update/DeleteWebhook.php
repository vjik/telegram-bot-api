<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Update;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#deletewebhook
 *
 * @template-implements MethodInterface<true>
 */
final readonly class DeleteWebhook implements MethodInterface
{
    public function __construct(
        private ?bool $dropPendingUpdates = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteWebhook';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'drop_pending_updates' => $this->dropPendingUpdates,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
