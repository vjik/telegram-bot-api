<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\UpdatingMessage;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\FileCollector;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\SetBusinessAccountProfilePhoto;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputProfilePhoto;

use Vjik\TelegramBot\Api\Type\InputProfilePhotoStatic;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetBusinessAccountProfilePhotoTest extends TestCase
{
    public function testBase(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $photo = new InputProfilePhotoStatic($file);
        $method = new SetBusinessAccountProfilePhoto('bcid1', $photo);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setBusinessAccountProfilePhoto', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'photo' => $photo->toRequestArray(new FileCollector()),
                'file0' => $file
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $photo = new InputProfilePhotoStatic($file);
        $method = new SetBusinessAccountProfilePhoto('bcid1', $photo, true);

        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'photo' => $photo->toRequestArray(new FileCollector()),
                'is_public' => true,
                'file0' => $file
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $photo = new InputProfilePhotoStatic($file);
        $method = new SetBusinessAccountProfilePhoto('bcid1', $photo);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
