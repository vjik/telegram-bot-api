<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetFile;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetFileTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetFile('f1');

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getFile', $method->getApiMethod());
        assertSame(['file_id' => 'f1'], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetFile('f1');

        $preparedResult = TestHelper::createSuccessStubApi([
            'file_id' => 'x1',
            'file_unique_id' => 'fullX1',
            'file_size' => 123,
            'file_path' => 'path/to/file',
        ])->call($method);

        assertSame('x1', $preparedResult->fileId);
    }
}
