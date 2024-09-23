<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Request;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ValueProcessorInterface;

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
