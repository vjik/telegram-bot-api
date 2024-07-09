<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ValueProcessorInterface;

/**
 * @internal
 */
final readonly class Param
{
    /**
     * @psalm-param class-string|ValueProcessorInterface $type
     */
    public function __construct(
        public string $key,
        public string|ValueProcessorInterface $type,
        public bool $optional,
    ) {}
}
