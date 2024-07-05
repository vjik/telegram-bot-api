<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;

interface ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): mixed;
}
