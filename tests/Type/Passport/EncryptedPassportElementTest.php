<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Passport\EncryptedPassportElement;
use Vjik\TelegramBot\Api\Type\Passport\PassportFile;

final class EncryptedPassportElementTest extends TestCase
{
    public function testBase(): void
    {
        $encryptedPassportElement = new EncryptedPassportElement('personal_details', '2');

        $this->assertSame('personal_details', $encryptedPassportElement->type);
        $this->assertSame('2', $encryptedPassportElement->hash);
        $this->assertNull($encryptedPassportElement->data);
        $this->assertNull($encryptedPassportElement->phoneNumber);
        $this->assertNull($encryptedPassportElement->email);
        $this->assertNull($encryptedPassportElement->files);
        $this->assertNull($encryptedPassportElement->frontSide);
        $this->assertNull($encryptedPassportElement->reverseSide);
        $this->assertNull($encryptedPassportElement->selfie);
        $this->assertNull($encryptedPassportElement->translation);
    }

    public function testFromTelegramResult(): void
    {
        $encryptedPassportElement = (new ObjectFactory())->create([
            'type' => 'personal_details',
            'hash' => 'test-hash',
            'data' => 'test-data',
            'phone_number' => '+71231234567',
            'email' => 'test@example.com',
            'files' => [
                [
                    'file_id' => '5',
                    'file_unique_id' => '6',
                    'file_size' => 7,
                    'file_date' => 1717512173
                ],
            ],
            'front_side' => [
                'file_id' => '8',
                'file_unique_id' => '9',
                'file_size' => 10,
                'file_date' => 1717512174
            ],
            'reverse_side' => [
                'file_id' => '11',
                'file_unique_id' => '12',
                'file_size' => 13,
                'file_date' => 1717512175
            ],
            'selfie' => [
                'file_id' => '14',
                'file_unique_id' => '15',
                'file_size' => 16,
                'file_date' => 1717512176
            ],
            'translation' => [
                [
                    'file_id' => '17',
                    'file_unique_id' => '18',
                    'file_size' => 19,
                    'file_date' => 1717512177
                ]
            ],
        ], null, EncryptedPassportElement::class);

        $this->assertSame('personal_details', $encryptedPassportElement->type);
        $this->assertSame('test-hash', $encryptedPassportElement->hash);
        $this->assertSame('test-data', $encryptedPassportElement->data);
        $this->assertSame('+71231234567', $encryptedPassportElement->phoneNumber);
        $this->assertSame('test@example.com', $encryptedPassportElement->email);

        $this->assertIsArray($encryptedPassportElement->files);
        $this->assertCount(1, $encryptedPassportElement->files);
        $this->assertInstanceOf(PassportFile::class, $encryptedPassportElement->files[0]);
        $this->assertSame('5', $encryptedPassportElement->files[0]->fileId);

        $this->assertInstanceOf(PassportFile::class, $encryptedPassportElement->frontSide);
        $this->assertSame('8', $encryptedPassportElement->frontSide->fileId);

        $this->assertInstanceOf(PassportFile::class, $encryptedPassportElement->reverseSide);
        $this->assertSame('11', $encryptedPassportElement->reverseSide->fileId);

        $this->assertInstanceOf(PassportFile::class, $encryptedPassportElement->selfie);
        $this->assertSame('14', $encryptedPassportElement->selfie->fileId);

        $this->assertIsArray($encryptedPassportElement->translation);
        $this->assertCount(1, $encryptedPassportElement->translation);
        $this->assertInstanceOf(PassportFile::class, $encryptedPassportElement->translation[0]);
        $this->assertSame('17', $encryptedPassportElement->translation[0]->fileId);
    }
}
