<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ResponseParameters;

final class ResponseParametersTest extends TestCase
{
    public function testBase(): void
    {
        $parameters = new ResponseParameters();

        $this->assertNull($parameters->migrateToChatId);
        $this->assertNull($parameters->retryAfter);
    }

    public function testFromDecodedBody()
    {
        $parameters = ResponseParameters::fromDecodedBody([
            'parameters' => [
                'migrate_to_chat_id' => 42,
                'retry_after' => 43,
            ],
        ]);

        $this->assertSame(42, $parameters->migrateToChatId);
        $this->assertSame(43, $parameters->retryAfter);
    }

    public function testFromDecodedBodyWithoutParameters(): void
    {
        $parameters = ResponseParameters::fromDecodedBody(['type' => 'parameters']);
        $this->assertNull($parameters);
    }

    public function testFromDecodedBodyWithNonArrayParameters(): void
    {
        $parameters = ResponseParameters::fromDecodedBody(['parameters' => 42]);
        $this->assertNull($parameters);
    }
}
