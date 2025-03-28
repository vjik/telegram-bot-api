<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SendGift;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SendGiftTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendGift(7, 'gid');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendGift', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 7,
                'gift_id' => 'gid',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 5);
        $method = new SendGift(9, 'gift-id', 'hello', 'MarkdownV2', [$entity], true, 95);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendGift', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 9,
                'chat_id' => 95,
                'gift_id' => 'gift-id',
                'pay_for_upgrade' => true,
                'text' => 'hello',
                'text_parse_mode' => 'MarkdownV2',
                'text_entities' => [$entity->toRequestArray()],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendGift(7, 'gid');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
