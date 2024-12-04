<?php

declare(strict_types=1);

namespace Type\Inline;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Inline\PreparedInlineMessage;

final class PreparedInlineMessageTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $type = new PreparedInlineMessage('id1', $date);

        $this->assertSame('id1', $type->id);
        $this->assertSame($date, $type->expirationDate);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'id' => 'id1',
            'expiration_date' => 1731917185,
        ], null, PreparedInlineMessage::class);

        $this->assertSame('id1', $type->id);
        $this->assertSame(1731917185, $type->expirationDate->getTimestamp());
    }
}