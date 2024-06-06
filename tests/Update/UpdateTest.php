<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Update;

use HttpSoft\Message\StreamTrait;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Update\Update;

final class UpdateTest extends TestCase
{
    public function testBase(): void
    {
        $update = new Update(99);

        $this->assertSame(99, $update->updateId);
        $this->assertNull($update->message);
        $this->assertNull($update->editedMessage);
        $this->assertNull($update->channelPost);
        $this->assertNull($update->editedChannelPost);
        $this->assertNull($update->businessConnection);
        $this->assertNull($update->businessMessage);
        $this->assertNull($update->editedBusinessMessage);
        $this->assertNull($update->deletedBusinessMessages);
        $this->assertNull($update->messageReaction);
        $this->assertNull($update->messageReactionCount);
        $this->assertNull($update->inlineQuery);
        $this->assertNull($update->chosenInlineResult);
        $this->assertNull($update->callbackQuery);
        $this->assertNull($update->shippingQuery);
        $this->assertNull($update->preCheckoutQuery);
        $this->assertNull($update->poll);
        $this->assertNull($update->pollAnswer);
        $this->assertNull($update->myChatMember);
        $this->assertNull($update->chatMember);
        $this->assertNull($update->chatJoinRequest);
        $this->assertNull($update->chatBoost);
        $this->assertNull($update->removedChatBoost);
    }

    public function testFromTelegramResult(): void
    {
        $update = Update::fromTelegramResult([
            'update_id' => 99,
            'message' => [
                'message_id' => 1,
                'date' => 1623150000,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'text' => 'Test message',
            ],
            'edited_message' => [
                'message_id' => 2,
                'date' => 1723150000,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'text' => 'Edited message',
            ],
            'channel_post' => [
                'message_id' => 3,
                'date' => 1823150000,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'text' => 'Channel post',
            ],
            'edited_channel_post' => [
                'message_id' => 4,
                'date' => 1923150000,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'text' => 'Edited channel post',
            ],
            'business_connection' => [
                'id' => 'bcid1',
                'user' => [
                    'id' => 123,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'user_chat_id' => 73,
                'date' => 124455000,
                'can_reply' => true,
                'is_enabled' => false,
            ],
            'business_message' => [
                'message_id' => 5,
                'date' => 2023150000,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'text' => 'Business message',
            ],
            'edited_business_message' => [
                'message_id' => 6,
                'date' => 2123150000,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'text' => 'Edited business message',
            ],
            'deleted_business_messages' => [
                'business_connection_id' => 'bcid2',
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'message_ids' => [7, 8],
            ],
            'message_reaction' => [
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'message_id' => 79,
                'date' => 555677431,
                'old_reaction' => [],
                'new_reaction' => [],
            ],
            'message_reaction_count' => [
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
                'message_id' => 80,
                'date' => 555677431,
                'reactions' => [],
            ],
            'inline_query' => [
                'id' => 'iqid1',
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'query' => 'inline query',
                'offset' => 'offset',
            ],
            'chosen_inline_result' => [
                'result_id' => 'ri1',
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'query' => 'inline query',
            ],
            'callback_query' => [
                'id' => 'cbid1',
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'chat_instance' => 'chat12',
            ],
            'shipping_query' => [
                'id' => 'sqid1',
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'invoice_payload' => 'payload',
                'shipping_address' => [
                    'country_code' => 'RU',
                    'state' => 'Moscow',
                    'city' => 'Moscow',
                    'street_line1' => 'Street',
                    'street_line2' => 'House',
                    'post_code' => '123456',
                ],
            ],
            'pre_checkout_query' => [
                'id' => 'pcqid1',
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'currency' => 'USD',
                'total_amount' => 100,
                'invoice_payload' => 'payload',
                'shipping_option_id' => 'soi1',
            ],
            'poll' => [
                'id' => 'poll1',
                'question' => 'Question',
                'options' => [
                    ['text' => 'Option 1', 'voter_count' => 7],
                    ['text' => 'Option 2', 'voter_count' => 5],
                ],
                'total_voter_count' => 12,
                'is_closed' => true,
                'is_anonymous' => false,
                'type' => 'regular',
                'allows_multiple_answers' => false,
            ],
            'poll_answer' => [
                'poll_id' => 'poll2',
                'option_ids' => [0],
            ],
            'my_chat_member' => [
                'chat' => [
                    'id' => 23712,
                    'type' => 'private',
                ],
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'date' => 555677431,
                'old_chat_member' => [
                    'status' => 'member',
                    'user' => [
                        'id' => 23,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
                'new_chat_member' => [
                    'status' => 'member',
                    'user' => [
                        'id' => 24,
                        'is_bot' => false,
                        'first_name' => 'Mike',
                    ],
                ],
            ],
            'chat_member' => [
                'chat' => [
                    'id' => 2399,
                    'type' => 'private',
                ],
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'date' => 555677431,
                'old_chat_member' => [
                    'status' => 'member',
                    'user' => [
                        'id' => 23,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
                'new_chat_member' => [
                    'status' => 'member',
                    'user' => [
                        'id' => 24,
                        'is_bot' => false,
                        'first_name' => 'Mike',
                    ],
                ],
            ],
            'chat_join_request' => [
                'chat' => [
                    'id' => 71326,
                    'type' => 'private',
                ],
                'from' => [
                    'id' => 23,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'user_chat_id' => 137,
                'date' => 1685000000,
            ],
            'chat_boost' => [
                'chat' => [
                    'id' => 23682,
                    'type' => 'private',
                ],
                'boost' => [
                    'boost_id' => 'bid12',
                    'add_date' => 1685000001,
                    'expiration_date' => 1735000001,
                    'source' => [
                        'source' => 'premium',
                        'user' => [
                            'id' => 23,
                            'is_bot' => false,
                            'first_name' => 'John',
                        ],
                    ],
                ],
            ],
            'removed_chat_boost' => [
                'chat' => [
                    'id' => 1735,
                    'type' => 'private',
                ],
                'boost_id' => 'bid15',
                'remove_date' => 1735000001,
                'source' => [
                    'source' => 'premium',
                    'user' => [
                        'id' => 23,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
            ],
        ]);

        $this->assertSame(99, $update->updateId);
        $this->assertSame(1, $update->message?->messageId);
        $this->assertSame(2, $update->editedMessage?->messageId);
        $this->assertSame(3, $update->channelPost?->messageId);
        $this->assertSame(4, $update->editedChannelPost?->messageId);
        $this->assertSame('bcid1', $update->businessConnection?->id);
        $this->assertSame(5, $update->businessMessage?->messageId);
        $this->assertSame(6, $update->editedBusinessMessage?->messageId);
        $this->assertSame('bcid2', $update->deletedBusinessMessages?->businessConnectionId);
        $this->assertSame(79, $update->messageReaction?->messageId);
        $this->assertSame(80, $update->messageReactionCount?->messageId);
        $this->assertSame('iqid1', $update->inlineQuery?->id);
        $this->assertSame('ri1', $update->chosenInlineResult?->resultId);
        $this->assertSame('cbid1', $update->callbackQuery?->id);
        $this->assertSame('sqid1', $update->shippingQuery?->id);
        $this->assertSame('pcqid1', $update->preCheckoutQuery?->id);
        $this->assertSame('poll1', $update->poll?->id);
        $this->assertSame('poll2', $update->pollAnswer?->pollId);
        $this->assertSame(23712, $update->myChatMember?->chat->id);
        $this->assertSame(2399, $update->chatMember?->chat->id);
        $this->assertSame(71326, $update->chatJoinRequest?->chat->id);
        $this->assertSame(23682, $update->chatBoost?->chat->id);
        $this->assertSame(1735, $update->removedChatBoost?->chat->id);
    }

    public function testFromJsonString(): void
    {
        $update = Update::fromJson('{"update_id":33990940}');
        $this->assertSame(33990940, $update->updateId);

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Failed to decode JSON.');
        Update::fromJson('asdf{');
    }

    public function testFromServerRequest(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getBody')->willReturn(
            new class () implements StreamInterface {
                use StreamTrait;

                public function __toString(): string
                {
                    return '{"update_id":33990940}';
                }
            }
        );

        $update = Update::fromServerRequest($request);
        $this->assertSame(33990940, $update->updateId);

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Failed to decode JSON.');
        Update::fromJson('asdf{');
    }
}
