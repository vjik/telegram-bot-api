<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Sticker;

use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Type\Sticker\Gifts;

/**
 * @see https://core.telegram.org/bots/api#getavailablegifts
 *
 * @template-implements TelegramRequestInterface<class-string<Gifts>>
 */
final readonly class GetAvailableGifts implements TelegramRequestInterface
{
    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getAvailableGifts';
    }

    public function getData(): array
    {
        return [];
    }

    public function getResultType(): string
    {
        return Gifts::class;
    }
}
