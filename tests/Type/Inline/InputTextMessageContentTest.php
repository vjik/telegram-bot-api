<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InputTextMessageContent;
use Vjik\TelegramBot\Api\Type\LinkPreviewOptions;
use Vjik\TelegramBot\Api\Type\MessageEntity;

final class InputTextMessageContentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InputTextMessageContent('Hello');

        $this->assertSame('Hello', $type->messageText);
        $this->assertNull($type->parseMode);
        $this->assertNull($type->entities);
        $this->assertNull($type->linkPreviewOptions);
        $this->assertSame(
            [
                'message_text' => 'Hello',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 4);
        $linkPreviewOptions = new LinkPreviewOptions(false);
        $type = new InputTextMessageContent('Hello', 'MarkdownV2', [$entity], $linkPreviewOptions);

        $this->assertSame('Hello', $type->messageText);
        $this->assertSame('MarkdownV2', $type->parseMode);
        $this->assertSame([$entity], $type->entities);
        $this->assertSame($linkPreviewOptions, $type->linkPreviewOptions);
        $this->assertSame(
            [
                'message_text' => 'Hello',
                'parse_mode' => 'MarkdownV2',
                'entities' => [
                    $entity->toRequestArray(),
                ],
                'link_preview_options' => $linkPreviewOptions->toRequestArray(),
            ],
            $type->toRequestArray(),
        );
    }
}
