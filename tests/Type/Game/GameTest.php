<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Game;

use PHPUnit\Framework\TestCase;
use Throwable;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Animation;
use Vjik\TelegramBot\Api\Type\Game\Game;
use Vjik\TelegramBot\Api\Type\PhotoSize;

final class GameTest extends TestCase
{
    public function testBase(): void
    {
        $game = new Game(
            'My Game',
            'The best game.',
            [
                new PhotoSize('id1', 'unique-id1', 100, 200),
            ],
        );

        $this->assertSame('My Game', $game->title);
        $this->assertSame('The best game.', $game->description);

        $this->assertCount(1, $game->photo);
        $this->assertSame('id1', $game->photo[0]->fileId);
        $this->assertSame('unique-id1', $game->photo[0]->fileUniqueId);
        $this->assertSame(100, $game->photo[0]->width);
        $this->assertSame(200, $game->photo[0]->height);
    }

    public function testFromTelegramResult(): void
    {
        $game = Game::fromTelegramResult([
            'title' => 'My Game',
            'description' => 'The best game.',
            'photo' => [
                [
                    'file_id' => 'id1',
                    'file_unique_id' => 'unique-id1',
                    'width' => 100,
                    'height' => 200,
                ],
            ],
            'text' => 'test text',
            'text_entities' => [
                [
                    'type' => 'bold',
                    'offset' => 0,
                    'length' => 4,
                ],
            ],
            'animation' => [
                'file_id' => 'id2',
                'file_unique_id' => 'unique-id2',
                'width' => 300,
                'height' => 400,
                'duration' => 12,
            ],
        ]);

        $this->assertSame('My Game', $game->title);
        $this->assertSame('The best game.', $game->description);

        $this->assertCount(1, $game->photo);
        $this->assertSame('id1', $game->photo[0]->fileId);
        $this->assertSame('unique-id1', $game->photo[0]->fileUniqueId);
        $this->assertSame(100, $game->photo[0]->width);
        $this->assertSame(200, $game->photo[0]->height);

        $this->assertSame('test text', $game->text);

        $this->assertIsArray($game->textEntities);
        $this->assertCount(1, $game->textEntities);
        $this->assertSame('bold', $game->textEntities[0]->type);
        $this->assertSame(0, $game->textEntities[0]->offset);
        $this->assertSame(4, $game->textEntities[0]->length);

        $this->assertInstanceOf(Animation::class, $game->animation);
        $this->assertSame('id2', $game->animation->fileId);
        $this->assertSame('unique-id2', $game->animation->fileUniqueId);
        $this->assertSame(300, $game->animation->width);
        $this->assertSame(400, $game->animation->height);
        $this->assertSame(12, $game->animation->duration);

        $exception = null;
        try {
            Game::fromTelegramResult(['title' => 'My Game'], ['test']);
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame('Not found key "description" in result object.', $exception->getMessage());
        $this->assertSame(['test'], $exception->raw);
    }
}
