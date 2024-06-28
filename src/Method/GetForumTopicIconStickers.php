<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#getforumtopiciconstickers
 */
final readonly class GetForumTopicIconStickers implements TelegramRequestWithResultPreparingInterface
{
    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getForumTopicIconStickers';
    }

    public function getData(): array
    {
        return [];
    }

    /**
     * @return Sticker[]
     */
    public function prepareResult(mixed $result): array
    {
        ValueHelper::assertArrayResult($result);
        return ValueHelper::getArrayOfStickers($result);
    }
}
