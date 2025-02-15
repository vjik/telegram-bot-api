<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\MaybeInaccessibleMessageValue;
use Vjik\TelegramBot\Api\Type\InaccessibleMessage;

use function PHPUnit\Framework\assertInstanceOf;

final class MaybeInaccessibleMessageValueTest extends TestCase
{
    public function testInvalidType(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MaybeInaccessibleMessageValue();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $processor->process('test', null, $objectFactory);
    }

    public function testWithoutDate(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MaybeInaccessibleMessageValue();

        $this->expectException(NotFoundKeyInResultException::class);
        $this->expectExceptionMessage('Not found key "date" in result object.');
        $processor->process([], null, $objectFactory);
    }

    public function testInvalidTypeOfDate(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MaybeInaccessibleMessageValue();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage(
            'Invalid type of value for key "date". Expected type is "integer", but got "string".',
        );
        $processor->process(['date' => '19.11.2013'], null, $objectFactory);
    }

    public function testInaccessibleMessage(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MaybeInaccessibleMessageValue();

        $result = $processor->process(
            [
                'message_id' => 7,
                'date' => 0,
                'chat' => [
                    'id' => 123456789,
                    'type' => 'private',
                ],
            ],
            null,
            $objectFactory,
        );

        assertInstanceOf(InaccessibleMessage::class, $result);
    }
}
