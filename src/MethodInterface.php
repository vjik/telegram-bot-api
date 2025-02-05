<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ValueProcessorInterface;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

/**
 * @template TResult
 *
 * @api
 */
interface MethodInterface
{
    /**
     * @see https://core.telegram.org/bots/api#available-methods
     */
    public function getApiMethod(): string;

    /**
     * @psalm-return array<string, mixed>
     */
    public function getData(): array;

    /**
     * @psalm-return ValueProcessorInterface<TResult>
     */
    public function getResultType(): ValueProcessorInterface;

    public function getHttpMethod(): HttpMethod;
}
