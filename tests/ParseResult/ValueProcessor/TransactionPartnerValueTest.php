<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TransactionPartnerValue;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerFragment;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerOther;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerTelegramAds;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerUser;

final class TransactionPartnerValueTest extends TestCase
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
                TransactionPartnerTelegramAds::class,
                [
                    'type' => 'telegram_ads',
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
    public function testBase(string $expectedClass, array $data): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new TransactionPartnerValue();

        $result = $processor->process($data, null, $objectFactory);

        $this->assertInstanceOf($expectedClass, $result);
    }

    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new TransactionPartnerValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown transaction partner type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}
