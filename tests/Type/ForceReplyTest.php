<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ForceReply;

final class ForceReplyTest extends TestCase
{
    public function testBase(): void
    {
        $forceReply = new ForceReply();

        $this->assertNull($forceReply->inputFieldPlaceholder);
        $this->assertNull($forceReply->selective);

        $this->assertSame(
            [
                'force_reply' => true,
            ],
            $forceReply->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $forceReply = new ForceReply('test', false);

        $this->assertSame('test', $forceReply->inputFieldPlaceholder);
        $this->assertFalse($forceReply->selective);

        $this->assertSame(
            [
                'force_reply' => true,
                'input_field_placeholder' => 'test',
                'selective' => false,
            ],
            $forceReply->toRequestArray(),
        );
    }
}
