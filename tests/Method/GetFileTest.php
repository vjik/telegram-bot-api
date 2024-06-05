<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetFile;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class GetFileTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetFile('f1');

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getFile', $method->getApiMethod());
        $this->assertSame(['file_id' => 'f1'], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetFile('f1');

        $preparedResult = $method->prepareResult([
            'file_id' => 'x1',
            'file_unique_id' => 'fullX1',
            'file_size' => 123,
            'file_path' => 'path/to/file',
        ]);

        $this->assertSame('x1', $preparedResult->fileId);
    }
}
