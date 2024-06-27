<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Passport\EncryptedCredentials;
use Vjik\TelegramBot\Api\Type\Passport\EncryptedPassportElement;
use Vjik\TelegramBot\Api\Type\Passport\PassportData;

final class PassportDataTest extends TestCase
{
    public function testBase(): void
    {
        $encryptedPassportElement = new EncryptedPassportElement('personal_details', '2');
        $encryptedCredentials = new EncryptedCredentials('a', 'b', 'c');
        $passportData = new PassportData(
            [$encryptedPassportElement],
            $encryptedCredentials,
        );

        $this->assertSame([$encryptedPassportElement], $passportData->data);
        $this->assertSame($encryptedCredentials, $passportData->credentials);
    }

    public function testFromTelegramResult(): void
    {
        $passportData = PassportData::fromTelegramResult([
            'data' => [
                [
                    'type' => 'personal_details',
                    'hash' => 'test-hash',
                ],
            ],
            'credentials' => [
                'data' => '1',
                'hash' => '2',
                'secret' => '3',
            ],
        ]);

        $this->assertCount(1, $passportData->data);
        $this->assertInstanceOf(EncryptedPassportElement::class, $passportData->data[0]);
        $this->assertSame('personal_details', $passportData->data[0]->type);
        $this->assertSame('test-hash', $passportData->data[0]->hash);

        $this->assertInstanceOf(EncryptedCredentials::class, $passportData->credentials);
        $this->assertSame('1', $passportData->credentials->data);
        $this->assertSame('2', $passportData->credentials->hash);
        $this->assertSame('3', $passportData->credentials->secret);
    }
}
