<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\SuggestedPostParameters;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class SuggestedPostParametersTest extends TestCase
{
    public function testBase(): void
    {
        $parameters = new SuggestedPostParameters();

        assertNull($parameters->price);
        assertNull($parameters->sendDate);
    }

    public function testFromTelegramResult(): void
    {
        $parameters = (new ObjectFactory())->create(
            [
                'price' => [
                    'currency' => 'XTR',
                    'amount' => 100,
                ],
                'send_date' => 1620000300,
            ],
            null,
            SuggestedPostParameters::class,
        );

        assertSame('XTR', $parameters->price?->currency);
        assertSame(100, $parameters->price?->amount);
        assertSame(1620000300, $parameters->sendDate);
    }
}