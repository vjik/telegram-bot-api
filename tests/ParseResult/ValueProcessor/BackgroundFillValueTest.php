<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\BackgroundFillValue;

final class BackgroundFillValueTest extends TestCase
{
    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new BackgroundFillValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown background fill type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}
