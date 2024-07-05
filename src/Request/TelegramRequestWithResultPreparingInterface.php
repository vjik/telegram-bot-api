<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Request;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ValueProcessorInterface;

interface TelegramRequestWithResultPreparingInterface extends TelegramRequestInterface
{
    /**
     * @psalm-return class-string|ValueProcessorInterface|null
     */
    public function getResultType(): string|ValueProcessorInterface|null;
}
