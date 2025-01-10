<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetForumTopicIconStickers;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

final class GetForumTopicIconStickersTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetForumTopicIconStickers();

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getForumTopicIconStickers', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetForumTopicIconStickers();

        $preparedResult = TestHelper::createSuccessStubApi([
            [
                'file_id' => 'x1',
                'file_unique_id' => 'fullX1',
                'type' => 'regular',
                'width' => 100,
                'height' => 120,
                'is_animated' => false,
                'is_video' => true,
            ],
        ])->send($method);

        $this->assertIsArray($preparedResult);
        $this->assertCount(1, $preparedResult);
        $this->assertInstanceOf(Sticker::class, $preparedResult[0]);
        $this->assertSame('x1', $preparedResult[0]->fileId);
    }
}
