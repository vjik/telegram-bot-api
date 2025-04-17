<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\FileCollector;
use Vjik\TelegramBot\Api\Method\PostStory;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputStoryContentPhoto;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\StoryArea;
use Vjik\TelegramBot\Api\Type\Story;
use Vjik\TelegramBot\Api\Type\StoryAreaPosition;
use Vjik\TelegramBot\Api\Type\StoryAreaTypeUniqueGift;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class PostStoryTest extends TestCase
{
    public function testBase(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $content = new InputStoryContentPhoto($file);
        $method = new PostStory('bcid1', $content, 86400);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('postStory', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'content' => $content->toRequestArray(new FileCollector()),
                'active_period' => 86400,
                'file0' => $file,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $content = new InputStoryContentPhoto($file);
        $captionEntities = [new MessageEntity('bold', 0, 4)];
        $storyArea = new StoryArea(
            new StoryAreaPosition(1, 2, 3, 4, 5, 6),
            new StoryAreaTypeUniqueGift('gift_id'),
        );
        $areas = [$storyArea];
        $method = new PostStory(
            'bcid1',
            $content,
            86400,
            'Test caption',
            'HTML',
            $captionEntities,
            $areas,
            true,
            true,
        );

        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'content' => $content->toRequestArray(new FileCollector()),
                'active_period' => 86400,
                'caption' => 'Test caption',
                'parse_mode' => 'HTML',
                'caption_entities' => array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $captionEntities,
                ),
                'areas' => array_map(
                    static fn(StoryArea $area) => $area->toRequestArray(),
                    $areas,
                ),
                'post_to_chat_page' => true,
                'protect_content' => true,
                'file0' => $file,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new PostStory(
            'bcid1',
            new InputStoryContentPhoto(new InputFile((new StreamFactory())->createStream())),
            86400,
        );

        $result = TestHelper::createSuccessStubApi([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'id' => 23,
        ])->call($method);

        assertInstanceOf(Story::class, $result);
        assertSame(23, $result->id);
    }
}
