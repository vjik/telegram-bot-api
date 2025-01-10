<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Passport\SetPassportDataErrors;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\Passport\PassportElementErrorSelfie;

final class SetPassportDataErrorsTest extends TestCase
{
    public function testBase(): void
    {
        $error = new PassportElementErrorSelfie('driver_license', 'qwerty', 'Test message');
        $method = new SetPassportDataErrors(1, [$error]);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setPassportDataErrors', $method->getApiMethod());
        $this->assertSame(
            [
                'user_id' => 1,
                'errors' => [$error->toRequestArray()],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetPassportDataErrors(1, []);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        $this->assertTrue($preparedResult);
    }
}
