<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#getforumtopiciconstickers
 *
 * @template-implements TelegramRequestInterface<ArrayOfObjectsValue<Sticker>>
 */
final readonly class GetForumTopicIconStickers implements TelegramRequestInterface
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

    public function getResultType(): ArrayOfObjectsValue
    {
        return new ArrayOfObjectsValue(Sticker::class);
    }
}
