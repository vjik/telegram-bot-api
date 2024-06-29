<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Game;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Game\GameHighScore;
use Vjik\TelegramBot\Api\Type\User;

final class GameHighScoreTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'test');
        $type = new GameHighScore(2, $user, 300);

        $this->assertSame(2, $type->position);
        $this->assertSame($user, $type->user);
        $this->assertSame(300, $type->score);
    }

    public function testFromTelegramResult(): void
    {
        $type = GameHighScore::fromTelegramResult([
            'position' => 2,
            'user' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'test',
            ],
            'score' => 300,
        ]);

        $this->assertSame(2, $type->position);
        $this->assertSame(1, $type->user->id);
        $this->assertSame(300, $type->score);
    }
}
