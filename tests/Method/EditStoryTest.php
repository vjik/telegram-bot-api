<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\FileCollector;
use Vjik\TelegramBot\Api\Method\EditStory;
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

final class EditStoryTest extends TestCase
{
    public function testBase(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $content = new InputStoryContentPhoto($file);
        $method = new EditStory('bcid1', 123, $content);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editStory', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'story_id' => 123,
                'content' => $content->toRequestArray(new FileCollector()),
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
        $method = new EditStory(
            'bcid1',
            123,
            $content,
            'Test caption',
            'HTML',
            $captionEntities,
            $areas,
        );

        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'story_id' => 123,
                'content' => $content->toRequestArray(new FileCollector()),
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
                'file0' => $file,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditStory(
            'bcid1',
            123,
            new InputStoryContentPhoto(new InputFile((new StreamFactory())->createStream()))
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
