<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\InaccessibleMessage;
use Vjik\TelegramBot\Api\Type\MaybeInaccessibleMessageFactory;
use Vjik\TelegramBot\Api\Type\Message;

final class MaybeInaccessibleMessageFactoryTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                InaccessibleMessage::class,
                [
                    'chat' => [
                        'id' => 123,
                        'type' => 'private',
                    ],
                    'message_id' => 98,
                    'date' => 0,
                ],
            ],
            [
                Message::class,
                [
                    'message_id' => 99,
                    'chat' => [
                        'id' => 123,
                        'type' => 'private',
                    ],
                    'date' => 1232156887,
                    'text' => 'test',
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, mixed $result): void
    {
        $entity = MaybeInaccessibleMessageFactory::fromTelegramResult($result);
        $this->assertInstanceOf($expectedClass, $entity);
    }
}
