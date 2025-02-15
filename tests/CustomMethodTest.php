<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\IntegerValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\CustomMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InputFile;

use function PHPUnit\Framework\assertSame;

final class CustomMethodTest extends TestCase
{
    public function testBase(): void
    {
        $photo = new InputFile((new StreamFactory())->createStream('test'));
        $method = new CustomMethod(
            'getMe',
            ['param1' => 'value1', 'photo' => $photo],
            new IntegerValue(),
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('getMe', $method->getApiMethod());
        assertSame(['param1' => 'value1', 'photo' => $photo], $method->getData());

        assertSame(33, TestHelper::createSuccessStubApi(33)->call($method));
    }

    public function testWithoutSuccessCallback(): void
    {
        $method = new CustomMethod('getMe');

        assertSame(33, TestHelper::createSuccessStubApi(33)->call($method));
    }
}
