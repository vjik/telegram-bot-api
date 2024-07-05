<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult;

use LogicException;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ResultFactory;
use Vjik\TelegramBot\Api\Tests\Support\Car;
use Vjik\TelegramBot\Api\Type\BotName;

final class ResultFactoryTest extends TestCase
{
    public function testUnsupportedPhpType(): void
    {
        $factory = new ResultFactory();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Unsupported PHP type.');
        $factory->create(['engine' => 'test'], Car::class);
    }

    public function testNotFoundKey(): void
    {
        $factory = new ResultFactory();

        $this->expectException(NotFoundKeyInResultException::class);
        $this->expectExceptionMessage('Not found key "name" in result object.');
        $factory->create([], BotName::class);
    }

    public function testInvalidTypeOfValueWithKey(): void
    {
        $factory = new ResultFactory();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage(
            'Invalid type of value for key "name". Expected type is "string", but got "int".'
        );
        $factory->create(['name' => 23], BotName::class);
    }
}
