<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Update;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#getwebhookinfo
 */
final readonly class GetWebhookInfo implements TelegramRequestInterface
{
    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getWebhookInfo';
    }

    public function getData(): array
    {
        return [];
    }

    public function getSuccessCallback(): ?callable
    {
        return static function (mixed $result): WebhookInfo {
            ValueHelper::assertArrayResult($result);
            return WebhookInfo::fromTelegramResult($result);
        };
    }
}
