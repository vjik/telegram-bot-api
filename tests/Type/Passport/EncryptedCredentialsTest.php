<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Throwable;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Passport\EncryptedCredentials;

final class EncryptedCredentialsTest extends TestCase
{
    public function testBase(): void
    {
        $encryptedCredentials = new EncryptedCredentials('1', '2', '3');

        $this->assertSame('1', $encryptedCredentials->data);
        $this->assertSame('2', $encryptedCredentials->hash);
        $this->assertSame('3', $encryptedCredentials->secret);
    }

    public function testFromTelegramResult(): void
    {
        $encryptedCredentials = EncryptedCredentials::fromTelegramResult([
            'data' => '1',
            'hash' => '2',
            'secret' => '3',
        ]);

        $this->assertSame('1', $encryptedCredentials->data);
        $this->assertSame('2', $encryptedCredentials->hash);
        $this->assertSame('3', $encryptedCredentials->secret);

        $exception = null;
        try {
            EncryptedCredentials::fromTelegramResult([], ['test']);
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Not found key "data" in result object.',
            $exception->getMessage()
        );
        $this->assertSame(['test'], $exception->raw);
    }
}
