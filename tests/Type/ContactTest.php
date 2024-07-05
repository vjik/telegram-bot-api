<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Contact;

final class ContactTest extends TestCase
{
    public function testBase(): void
    {
        $contact = new Contact('+3123456', 'Mike');

        $this->assertSame('+3123456', $contact->phoneNumber);
        $this->assertSame('Mike', $contact->firstName);
        $this->assertNull($contact->lastName);
        $this->assertNull($contact->userId);
        $this->assertNull($contact->vcard);
    }

    public function testFromTelegramResult(): void
    {
        $contact = (new ObjectFactory())->create([
            'phone_number' => '+3123456',
            'first_name' => 'Mike',
            'last_name' => 'Smith',
            'user_id' => 123,
            'vcard' => 'vcard',
        ], null, Contact::class);

        $this->assertSame('+3123456', $contact->phoneNumber);
        $this->assertSame('Mike', $contact->firstName);
        $this->assertSame('Smith', $contact->lastName);
        $this->assertSame(123, $contact->userId);
        $this->assertSame('vcard', $contact->vcard);
    }
}
