<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerFactory;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerFragment;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerOther;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerUser;

final class TransactionPartnerFactoryTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                TransactionPartnerFragment::class,
                [
                    'type' => 'fragment',
                ],
            ],
            [
                TransactionPartnerUser::class,
                [
                    'type' => 'user',
                    'user' => [
                        'id' => 12,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
            ],
            [
                TransactionPartnerOther::class,
                [
                    'type' => 'other',
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $result): void
    {
        $result = TransactionPartnerFactory::fromTelegramResult($result);
        $this->assertInstanceOf($expectedClass, $result);
    }

    public function testInvalidType(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown transaction partner type.');
        TransactionPartnerFactory::fromTelegramResult([
            'type' => 'invalid',
        ]);
    }
}
