<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#close
 *
 * @template-implements MethodInterface<true>
 */
final readonly class Close implements MethodInterface
{
    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'close';
    }

    public function getData(): array
    {
        return [];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
