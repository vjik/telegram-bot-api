<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GiftPremiumSubscription;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use Vjik\TelegramBot\Api\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class GiftPremiumSubscriptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GiftPremiumSubscription(123456789, 3, 1000);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('giftPremiumSubscription', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 123456789,
                'month_count' => 3,
                'star_count' => 1000,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 5);
        $method = new GiftPremiumSubscription(
            123456789,
            6,
            1500,
            'Happy Birthday!',
            'Markdown',
            [$entity],
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('giftPremiumSubscription', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 123456789,
                'month_count' => 6,
                'star_count' => 1500,
                'text' => 'Happy Birthday!',
                'text_parse_mode' => 'Markdown',
                'text_entities' => [$entity->toRequestArray()],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GiftPremiumSubscription(123456789, 12, 2500);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
