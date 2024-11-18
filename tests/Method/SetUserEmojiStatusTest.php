<?php

declare(strict_types=1);

namespace Method;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetUserEmojiStatus;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class SetUserEmojiStatusTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetUserEmojiStatus(1);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setUserEmojiStatus', $method->getApiMethod());
        $this->assertSame(
            [
                'user_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $date = new DateTimeImmutable();
        $method = new SetUserEmojiStatus(9, 'test', $date);

        $this->assertSame(
            [
                'user_id' => 9,
                'emoji_status_custom_emoji_id' => 'test',
                'emoji_status_expiration_date' => $date->getTimestamp(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetUserEmojiStatus(1);

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}
