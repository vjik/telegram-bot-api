<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\InputPollOption;
use Vjik\TelegramBot\Api\Type\MessageEntity;

final class InputPollOptionTest extends TestCase
{
    public function testBase(): void
    {
        $option = new InputPollOption();

        $this->assertNull($option->text);
        $this->assertNull($option->textParseMode);
        $this->assertNull($option->textEntities);

        $this->assertSame([], $option->toRequestArray());
    }

    public function testFilled(): void
    {
        $messageEntity = new MessageEntity('bold', 0, 4);
        $option = new InputPollOption('test', 'MarkdownV2', [$messageEntity]);

        $this->assertSame('test', $option->text);
        $this->assertSame('MarkdownV2', $option->textParseMode);
        $this->assertSame([$messageEntity], $option->textEntities);

        $this->assertSame(
            [
                'text' => 'test',
                'text_parse_mode' => 'MarkdownV2',
                'text_entities' => [$messageEntity->toRequestArray()],
            ],
            $option->toRequestArray(),
        );
    }
}
