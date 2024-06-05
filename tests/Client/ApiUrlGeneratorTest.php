<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Client;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Client\ApiUrlGenerator;

final class ApiUrlGeneratorTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                'https://api.telegram.org/bot04062024/getWebhookInfo',
                'getWebhookInfo',
            ],
            [
                'https://api.telegram.org/bot04062024/getChat?chat_id=%40sergei_predvoditelev',
                'getChat',
                ['chat_id' => '@sergei_predvoditelev']
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expected, string $method, array $queryParameters = []): void
    {
        $generator = new ApiUrlGenerator('04062024', 'https://api.telegram.org');
        $result = $generator->generate($method, $queryParameters);
        $this->assertSame($expected, $result);
    }
}
