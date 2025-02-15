<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Passport;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Passport\SetPassportDataErrors;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\Passport\PassportElementErrorSelfie;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetPassportDataErrorsTest extends TestCase
{
    public function testBase(): void
    {
        $error = new PassportElementErrorSelfie('driver_license', 'qwerty', 'Test message');
        $method = new SetPassportDataErrors(1, [$error]);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setPassportDataErrors', $method->getApiMethod());
        assertSame(
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

        assertTrue($preparedResult);
    }
}
