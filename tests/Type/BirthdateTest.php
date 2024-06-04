<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Birthdate;

final class BirthdateTest extends TestCase
{
    public function testBase(): void
    {
        $birthdate = new Birthdate(27, 1);

        $this->assertSame(27, $birthdate->day);
        $this->assertSame(1, $birthdate->month);
        $this->assertNull($birthdate->year);
    }

    public function testFromTelegramResult(): void
    {
        $birthdate = Birthdate::fromTelegramResult([
            'day' => 27,
            'month' => 1,
            'year' => 1986,
        ]);

        $this->assertSame(27, $birthdate->day);
        $this->assertSame(1, $birthdate->month);
        $this->assertSame(1986, $birthdate->year);
    }

}
