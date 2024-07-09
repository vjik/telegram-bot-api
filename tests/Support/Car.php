<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Support;

final readonly class Car
{
    public function __construct(
        public string|int $engine,
    ) {}
}
