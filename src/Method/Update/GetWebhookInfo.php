<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Update;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Update\WebhookInfo;

/**
 * @see https://core.telegram.org/bots/api#getwebhookinfo
 */
final readonly class GetWebhookInfo implements TelegramRequestWithResultPreparingInterface
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

    public function prepareResult(mixed $result): WebhookInfo
    {
        return WebhookInfo::fromTelegramResult($result);
    }
}
