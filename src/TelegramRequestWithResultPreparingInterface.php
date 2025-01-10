<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ValueProcessorInterface;
use Vjik\TelegramBot\Api\Transport\TelegramRequestInterface;

/**
 * @template T as class-string|ValueProcessorInterface|null
 */
interface TelegramRequestWithResultPreparingInterface extends TelegramRequestInterface
{
    /**
     * @psalm-return T
     */
    public function getResultType(): string|ValueProcessorInterface|null;
}
