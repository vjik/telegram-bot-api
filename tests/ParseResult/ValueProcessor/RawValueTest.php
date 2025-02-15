<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\RawValue;

use function PHPUnit\Framework\assertSame;

final class RawValueTest extends TestCase
{
    public static function dataBase(): iterable
    {
        yield ['test'];
        yield [42];
        yield [new stdClass()];
    }

    #[DataProvider('dataBase')]
    public function testBase(mixed $value): void
    {
        $processor = new RawValue();
        assertSame($value, $processor->process($value, null, new ObjectFactory()));
    }
}
