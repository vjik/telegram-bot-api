<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests;

use HttpSoft\Message\StreamFactory;
use LogicException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Throwable;
use Vjik\TelegramBot\Api\Client\TelegramResponse;
use Vjik\TelegramBot\Api\FailResult;
use Vjik\TelegramBot\Api\Method\GetMe;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\TelegramBotApi;
use Vjik\TelegramBot\Api\Tests\Support\StubTelegramClient;
use Vjik\TelegramBot\Api\Tests\Support\StubTelegramRequest;
use Vjik\TelegramBot\Api\Type\BotCommand;
use Vjik\TelegramBot\Api\Type\BotDescription;
use Vjik\TelegramBot\Api\Type\BotName;
use Vjik\TelegramBot\Api\Type\BotShortDescription;
use Vjik\TelegramBot\Api\Type\BusinessConnection;
use Vjik\TelegramBot\Api\Type\ChatFullInfo;
use Vjik\TelegramBot\Api\Type\ChatInviteLink;
use Vjik\TelegramBot\Api\Type\ChatMemberMember;
use Vjik\TelegramBot\Api\Type\ChatPermissions;
use Vjik\TelegramBot\Api\Type\File;
use Vjik\TelegramBot\Api\Type\ForumTopic;
use Vjik\TelegramBot\Api\Type\Game\GameHighScore;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultContact;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultGame;
use Vjik\TelegramBot\Api\Type\Inline\PreparedInlineMessage;
use Vjik\TelegramBot\Api\Type\Inline\SentWebAppMessage;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputMediaPhoto;
use Vjik\TelegramBot\Api\Type\MenuButtonDefault;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\MessageId;
use Vjik\TelegramBot\Api\Type\Payment\StarTransactions;
use Vjik\TelegramBot\Api\Type\Sticker\InputSticker;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;
use Vjik\TelegramBot\Api\Type\User;
use Vjik\TelegramBot\Api\Type\UserChatBoosts;
use Vjik\TelegramBot\Api\Type\UserProfilePhotos;
use Vjik\TelegramBot\Api\Type\Update\Update;
use Vjik\TelegramBot\Api\Type\Update\WebhookInfo;
use Yiisoft\Test\Support\Log\SimpleLogger;

final class TelegramBotApiTest extends TestCase
{
    public function testWithLogger(): void
    {
        $logger1 = new SimpleLogger();
        $logger2 = new SimpleLogger();

        $api1 = new TelegramBotApi(
            new StubTelegramClient(
                new TelegramResponse(200, '[]'),
            ),
            $logger1,
        );
        $api2 = $api1->withLogger($logger2);

        try {
            $api2->send(new StubTelegramRequest());
        } catch (TelegramParseResultException) {
        }

        $this->assertNotSame($api1, $api2);
        $this->assertEmpty($logger1->getMessages());
        $this->assertCount(2, $logger2->getMessages());
    }

    public function testSendSuccess(): void
    {
        $logger = new SimpleLogger();
        $request = new GetMe();
        $response = new TelegramResponse(200, '{"ok":true,"result":{"id":1,"is_bot":false,"first_name":"Sergei"}}');
        $api = $this->createApi($response, logger: $logger);

        $result = $api->send($request);

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame(1, $result->id);

        $this->assertSame(
            [
                [
                    'level' => 'info',
                    'message' => 'Send GET-request "getMe".',
                    'context' => [
                        'type' => 1,
                        'payload' => '[]',
                        'request' => $request,
                    ],
                ],
                [
                    'level' => 'info',
                    'message' => 'On "getMe" request Telegram Bot API returned successful result.',
                    'context' => [
                        'type' => 2,
                        'payload' => '{"ok":true,"result":{"id":1,"is_bot":false,"first_name":"Sergei"}}',
                        'request' => $request,
                        'response' => $response,
                        'decodedResponse' => [
                            'ok' => true,
                            'result' => [
                                'id' => 1,
                                'is_bot' => false,
                                'first_name' => 'Sergei',
                            ],
                        ],
                    ],
                ],
            ],
            $logger->getMessages(),
        );
    }

    public function testSendSimpleRequest(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
        ]);

        $result = $api->send(new StubTelegramRequest());

        $this->assertSame(
            [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
            $result,
        );
    }

    public function testSendFail(): void
    {
        $logger = new SimpleLogger();
        $request = new GetMe();
        $response = new TelegramResponse(200, '{"ok":false,"description":"test error"}');
        $api = $this->createApi($response, logger: $logger);

        $result = $api->send($request);

        $this->assertInstanceOf(FailResult::class, $result);
        $this->assertSame('test error', $result->description);

        $this->assertSame(
            [
                [
                    'level' => 'info',
                    'message' => 'Send GET-request "getMe".',
                    'context' => [
                        'type' => 1,
                        'payload' => '[]',
                        'request' => $request,
                    ],
                ],
                [
                    'level' => 'warning',
                    'message' => 'On "getMe" request Telegram Bot API returned fail result.',
                    'context' => [
                        'type' => 3,
                        'payload' => '{"ok":false,"description":"test error"}',
                        'request' => $request,
                        'response' => $response,
                        'decodedResponse' => [
                            'ok' => false,
                            'description' => 'test error',
                        ],
                    ],
                ],
            ],
            $logger->getMessages(),
        );
    }

    public function testSuccessResponseWithoutResult(): void
    {
        $api = $this->createApi([
            'ok' => true,
        ]);

        $exception = null;
        try {
            $api->send(new GetMe());
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame('Not found "result" field in response. Status code: 200.', $exception->getMessage());
    }

    public function testResponseWithInvalidJson(): void
    {
        $api = $this->createApi('g {12}');

        $exception = null;
        try {
            $api->send(new GetMe());
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame('Failed to decode JSON response. Status code: 200.', $exception->getMessage());
    }

    public function testResponseWithInvalidResult(): void
    {
        $logger = new SimpleLogger();
        $request = new GetMe();
        $api = $this->createApi('{"ok":true,"result":[]}', logger: $logger);

        $exception = null;
        try {
            $api->send($request);
        } catch (Throwable $exception) {
        }

        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame('Not found key "id" in result object.', $exception->getMessage());
        $this->assertSame(
            [
                [
                    'level' => 'info',
                    'message' => 'Send GET-request "getMe".',
                    'context' => [
                        'type' => 1,
                        'payload' => '[]',
                        'request' => $request,
                    ],
                ],
                [
                    'level' => 'error',
                    'message' => 'Failed to parse telegram result. Not found key "id" in result object.',
                    'context' => [
                        'type' => 4,
                        'payload' => '{"ok":true,"result":[]}',
                    ],
                ],
            ],
            $logger->getMessages(),
        );
    }

    public function testNotArrayResponse(): void
    {
        $api = $this->createApi('"hello"');

        $exception = null;
        try {
            $api->send(new GetMe());
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame('Expected telegram response as array. Got "string".', $exception->getMessage());
    }

    public function testResponseWithNotBooleanOk(): void
    {
        $api = $this->createApi([
            'ok' => 'true',
        ]);

        $exception = null;
        try {
            $api->send(new GetMe());
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame('Incorrect "ok" field in response. Status code: 200.', $exception->getMessage());
    }

    public function testAddStickerToSet(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->addStickerToSet(
            1,
            'test',
            new InputSticker('https://example.com/sticker.webp', 'static', ['😀']),
        );

        $this->assertTrue($result);
    }

    public function testAnswerCallbackQuery(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->answerCallbackQuery('id');

        $this->assertTrue($result);
    }

    public function testAnswerInlineQuery(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->answerInlineQuery('id', []);

        $this->assertTrue($result);
    }

    public function testAnswerPreCheckoutQuery(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->answerPreCheckoutQuery('id', true);

        $this->assertTrue($result);
    }

    public function testAnswerShippingQuery(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->answerShippingQuery('id', true);

        $this->assertTrue($result);
    }

    public function testAnswerWebAppQuery(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'inline_message_id' => 'idMessage',
            ],
        ]);

        $result = $api->answerWebAppQuery('id', new InlineQueryResultContact('1', '+79001234567', 'Vjik'));

        $this->assertInstanceOf(SentWebAppMessage::class, $result);
        $this->assertSame('idMessage', $result->inlineMessageId);
    }

    public function testApproveChatJoinRequest(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->approveChatJoinRequest(1, 2);

        $this->assertTrue($result);
    }

    public function testBanChatMember(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->banChatMember(1, 2);

        $this->assertTrue($result);
    }

    public function testBanChatSenderChat(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->banChatSenderChat(1, 2);

        $this->assertTrue($result);
    }

    public function testClose(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->close();

        $this->assertTrue($result);
    }

    public function testCloseForumTopic(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->closeForumTopic(1, 2);

        $this->assertTrue($result);
    }

    public function testCloseGeneralForumTopic(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->closeGeneralForumTopic(1);

        $this->assertTrue($result);
    }

    public function testCopyMessage(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
            ],
        ]);

        $result = $api->copyMessage(100, 200, 1);

        $this->assertInstanceOf(MessageId::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testCopyMessages(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                [
                    'message_id' => 7,
                ],
                [
                    'message_id' => 8,
                ],
            ],
        ]);

        $result = $api->copyMessages(100, 200, [1, 2]);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(MessageId::class, $result[0]);
        $this->assertInstanceOf(MessageId::class, $result[1]);
        $this->assertSame(7, $result[0]->messageId);
        $this->assertSame(8, $result[1]->messageId);
    }

    public function testCreateChatInviteLink(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'invite_link' => 'https//t.me/+example',
                'creator' => [
                    'id' => 1,
                    'is_bot' => true,
                    'first_name' => 'testBot',
                ],
                'creates_join_request' => true,
                'is_primary' => true,
                'is_revoked' => false,
            ],
        ]);

        $result = $api->createChatInviteLink(1);

        $this->assertInstanceOf(ChatInviteLink::class, $result);
        $this->assertSame('https//t.me/+example', $result->inviteLink);
    }

    public function testCreateChatSubscriptionInviteLink(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'invite_link' => 'https//t.me/+example',
                'creator' => [
                    'id' => 1,
                    'is_bot' => true,
                    'first_name' => 'testBot',
                ],
                'creates_join_request' => true,
                'is_primary' => true,
                'is_revoked' => false,
            ],
        ]);

        $result = $api->createChatSubscriptionInviteLink(10, 20, 30);

        $this->assertInstanceOf(ChatInviteLink::class, $result);
        $this->assertSame('https//t.me/+example', $result->inviteLink);
    }

    public function testCreateForumTopic(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_thread_id' => 19,
                'name' => 'test',
                'icon_color' => 0x00FF00,
                'icon_custom_emoji_id' => '2351346235143',
            ],
        ]);

        $result = $api->createForumTopic(1, 'test');

        $this->assertInstanceOf(ForumTopic::class, $result);
        $this->assertSame(19, $result->messageThreadId);
    }

    public function testCreateInvoiceLink(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => 'https://example.com/invoice',
        ]);

        $result = $api->createInvoiceLink(
            'The title',
            'The description',
            'The payload',
            'XTR',
            [],
        );

        $this->assertSame('https://example.com/invoice', $result);
    }

    public function testCreateNewStickerSet(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->createNewStickerSet(1, 'test_by_bot', 'Test Pack', []);

        $this->assertTrue($result);
    }

    public function testDeclineChatJoinRequest(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->declineChatJoinRequest(1, 2);

        $this->assertTrue($result);
    }

    public function testDeleteChatPhoto(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->deleteChatPhoto(1);

        $this->assertTrue($result);
    }

    public function testDeleteChatStickerSet(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->deleteChatStickerSet(1);

        $this->assertTrue($result);
    }

    public function testDeleteForumTopic(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->deleteForumTopic(1, 2);

        $this->assertTrue($result);
    }

    public function testDeleteMessage(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->deleteMessage(1, 2);

        $this->assertTrue($result);
    }

    public function testDeleteMessages(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->deleteMessages(1, []);

        $this->assertTrue($result);
    }

    public function testDeleteMyCommands(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->deleteMyCommands();

        $this->assertTrue($result);
    }

    public function testDeleteStickerFromSet(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->deleteStickerFromSet('sid');

        $this->assertTrue($result);
    }

    public function testDeleteStickerSet(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->deleteStickerSet('test_by_bot');

        $this->assertTrue($result);
    }

    public function testEditChatInviteLink(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'invite_link' => 'https//t.me/+example',
                'creator' => [
                    'id' => 23,
                    'is_bot' => true,
                    'first_name' => 'testBot',
                ],
                'creates_join_request' => true,
                'is_primary' => true,
                'is_revoked' => false,
            ],
        ]);

        $result = $api->editChatInviteLink(1, 'https//t.me/+example');

        $this->assertInstanceOf(ChatInviteLink::class, $result);
        $this->assertSame(23, $result->creator->id);
    }

    public function testEditChatSubscriptionInviteLink(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'invite_link' => 'https//t.me/+example',
                'creator' => [
                    'id' => 23,
                    'is_bot' => true,
                    'first_name' => 'testBot',
                ],
                'creates_join_request' => true,
                'is_primary' => true,
                'is_revoked' => false,
            ],
        ]);

        $result = $api->editChatSubscriptionInviteLink(1, 'https//t.me/+example');

        $this->assertInstanceOf(ChatInviteLink::class, $result);
        $this->assertSame(23, $result->creator->id);
    }

    public function testEditForumTopic(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->editForumTopic(1, 2);

        $this->assertTrue($result);
    }

    public function testEditGeneralForumTopic(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->editGeneralForumTopic(1, 'test');

        $this->assertTrue($result);
    }

    public function testEditMessageCaption(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->editMessageCaption();

        $this->assertTrue($result);
    }

    public function testEditMessageLiveLocation(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->editMessageLiveLocation(51.660781, 39.200296);

        $this->assertTrue($result);
    }

    public function testEditMessageMedia(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->editMessageMedia(
            new InputMediaPhoto('https://example.com/photo.jpg'),
        );

        $this->assertTrue($result);
    }

    public function testEditMessageReplyMarkup(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->editMessageReplyMarkup();

        $this->assertTrue($result);
    }

    public function testEditMessageText(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->editMessageText('test');

        $this->assertTrue($result);
    }

    public function testEditUserStarSubscription(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->editUserStarSubscription(7, 'id', false);

        $this->assertTrue($result);
    }

    public function testExportChatInviteLink(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => 'https//t.me/+example',
        ]);

        $result = $api->exportChatInviteLink(1);

        $this->assertSame('https//t.me/+example', $result);
    }

    public function testForwardMessage(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->forwardMessage(100, 200, 15);

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testForwardMessages(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                [
                    'message_id' => 7,
                ],
                [
                    'message_id' => 8,
                ],
            ],
        ]);

        $result = $api->forwardMessages(100, 200, [1, 2]);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(MessageId::class, $result[0]);
        $this->assertInstanceOf(MessageId::class, $result[1]);
        $this->assertSame(7, $result[0]->messageId);
        $this->assertSame(8, $result[1]->messageId);
    }

    public function testDeleteWebhook(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->deleteWebhook();

        $this->assertTrue($result);
    }

    public function testGetBusinessConnection(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'id' => 'id1',
                'user' => [
                    'id' => 123,
                    'is_bot' => false,
                    'first_name' => 'Sergei',
                ],
                'user_chat_id' => 23,
                'date' => 1717517779,
                'can_reply' => true,
                'is_enabled' => false,
            ],
        ]);

        $result = $api->getBusinessConnection('b1');

        $this->assertInstanceOf(BusinessConnection::class, $result);
        $this->assertSame('id1', $result->id);
    }

    public function testGetChat(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'id' => 23,
                'type' => 'private',
                'accent_color_id' => 0x123456,
                'max_reaction_count' => 5,
            ],
        ]);

        $result = $api->getChat(23);

        $this->assertInstanceOf(ChatFullInfo::class, $result);
        $this->assertSame(23, $result->id);
    }

    public function testGetChatAdministrators(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                [
                    'status' => 'member',
                    'user' => ['id' => 23, 'is_bot' => false, 'first_name' => 'Mike'],
                ],
            ],
        ]);

        $result = $api->getChatAdministrators(23);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(ChatMemberMember::class, $result[0]);
        $this->assertSame(23, $result[0]->user->id);
    }

    public function testGetChatMemberCount(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => 33,
        ]);

        $result = $api->getChatMemberCount(1);

        $this->assertSame(33, $result);
    }

    public function testGetChatMember(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'status' => 'member',
                'user' => ['id' => 23, 'is_bot' => false, 'first_name' => 'Mike'],
            ],
        ]);

        $result = $api->getChatMember(1, 2);

        $this->assertInstanceOf(ChatMemberMember::class, $result);
        $this->assertSame(23, $result->user->id);
    }

    public function testGetChatMenuButton(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'type' => 'default',
            ],
        ]);

        $result = $api->getChatMenuButton();

        $this->assertInstanceOf(MenuButtonDefault::class, $result);
    }

    public function testGetFile(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'file_id' => 'f1',
                'file_unique_id' => 'fullX1',
                'file_size' => 123,
                'file_path' => 'path/to/file',
            ],
        ]);

        $result = $api->getFile('f1');

        $this->assertInstanceOf(File::class, $result);
        $this->assertSame('f1', $result->fileId);
    }

    public function testGetForumTopicIconStickers(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                [
                    'file_id' => 'x1',
                    'file_unique_id' => 'fullX1',
                    'type' => 'regular',
                    'width' => 100,
                    'height' => 120,
                    'is_animated' => false,
                    'is_video' => true,
                ],
            ],
        ]);

        $result = $api->getForumTopicIconStickers();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Sticker::class, $result[0]);
        $this->assertSame('x1', $result[0]->fileId);
    }

    public function testGetGameHighScores(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                [
                    'position' => 2,
                    'user' => [
                        'id' => 1,
                        'is_bot' => false,
                        'first_name' => 'test',
                    ],
                    'score' => 300,
                ],
            ],
        ]);

        $result = $api->getGameHighScores(1);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(GameHighScore::class, $result[0]);
        $this->assertSame(2, $result[0]->position);
    }

    public function testGetCustomEmojiStickers(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                [
                    'file_id' => 'x1',
                    'file_unique_id' => 'fullX1',
                    'type' => 'regular',
                    'width' => 100,
                    'height' => 120,
                    'is_animated' => false,
                    'is_video' => true,
                ],
            ],
        ]);

        $result = $api->getCustomEmojiStickers(['id1']);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Sticker::class, $result[0]);
        $this->assertSame('x1', $result[0]->fileId);
    }

    public function testGetMe(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
        ]);

        $result = $api->getMe();

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame(1, $result->id);
    }

    public function testGetMyCommands(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                [
                    'command' => 'start',
                    'description' => 'Start command',
                ],
            ],
        ]);

        $result = $api->getMyCommands();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(BotCommand::class, $result[0]);
        $this->assertSame('start', $result[0]->command);
    }

    public function testGetMyDefaultAdministratorRights(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'is_anonymous' => true,
                'can_manage_chat' => false,
                'can_delete_messages' => true,
                'can_manage_video_chats' => true,
                'can_restrict_members' => false,
                'can_promote_members' => true,
                'can_change_info' => true,
                'can_invite_users' => true,
                'can_post_stories' => true,
                'can_edit_stories' => true,
                'can_delete_stories' => false,
                'can_post_messages' => true,
                'can_edit_messages' => true,
                'can_pin_messages' => false,
                'can_manage_topics' => true,
            ],
        ]);

        $result = $api->getMyDefaultAdministratorRights();

        $this->assertTrue($result->isAnonymous);
        $this->assertFalse($result->canManageChat);
        $this->assertTrue($result->canDeleteMessages);
        $this->assertTrue($result->canManageVideoChats);
        $this->assertFalse($result->canRestrictMembers);
        $this->assertTrue($result->canPromoteMembers);
        $this->assertTrue($result->canChangeInfo);
        $this->assertTrue($result->canInviteUsers);
        $this->assertTrue($result->canPostStories);
        $this->assertTrue($result->canEditStories);
        $this->assertFalse($result->canDeleteStories);
        $this->assertTrue($result->canPostMessages);
        $this->assertTrue($result->canEditMessages);
        $this->assertFalse($result->canPinMessages);
        $this->assertTrue($result->canManageTopics);
    }

    public function testGetMyDescription(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'description' => 'test',
            ],
        ]);

        $result = $api->getMyDescription();

        $this->assertInstanceOf(BotDescription::class, $result);
        $this->assertSame('test', $result->description);
    }

    public function testGetMyName(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'name' => 'test',
            ],
        ]);

        $result = $api->getMyName();

        $this->assertInstanceOf(BotName::class, $result);
        $this->assertSame('test', $result->name);
    }

    public function testGetMyShortDescription(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'short_description' => 'test',
            ],
        ]);

        $result = $api->getMyShortDescription();

        $this->assertInstanceOf(BotShortDescription::class, $result);
        $this->assertSame('test', $result->shortDescription);
    }

    public function testGetStarTransactions(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'transactions' => [],
            ],
        ]);

        $result = $api->getStarTransactions();

        $this->assertInstanceOf(StarTransactions::class, $result);
    }

    public function testGetStickerSet(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'name' => 'test_by_bot',
                'title' => 'test name',
                'sticker_type' => 'regular',
                'stickers' => [
                    [
                        'file_id' => 'fid1',
                        'file_unique_id' => 'fuid1',
                        'type' => 'regular',
                        'width' => 200,
                        'height' => 300,
                        'is_animated' => false,
                        'is_video' => false,
                    ],
                ],
            ],
        ]);

        $result = $api->getStickerSet('test_by_bot');

        $this->assertSame('test name', $result->title);
    }

    public function testGetUpdates(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                ['update_id' => 1],
                ['update_id' => 2],
            ],
        ]);

        $result = $api->getUpdates();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Update::class, $result[0]);
        $this->assertInstanceOf(Update::class, $result[1]);
        $this->assertSame(1, $result[0]->updateId);
        $this->assertSame(2, $result[1]->updateId);
    }

    public function testGetUserChatBoosts(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'boosts' => [],
            ],
        ]);

        $result = $api->getUserChatBoosts(1, 2);

        $this->assertInstanceOf(UserChatBoosts::class, $result);
    }

    public function testGetUserProfilePhotos(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'total_count' => 1,
                'photos' => [
                    [
                        [
                            'file_id' => 'f1',
                            'file_unique_id' => 'fullX1',
                            'file_size' => 123,
                            'width' => 100,
                            'height' => 200,
                        ],
                    ],
                ],
            ],
        ]);

        $result = $api->getUserProfilePhotos(7);

        $this->assertInstanceOf(UserProfilePhotos::class, $result);
    }

    public function testGetWebhookInfo(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'url' => 'https://example.com/',
                'has_custom_certificate' => true,
                'pending_update_count' => 12,
            ],
        ]);

        $result = $api->getWebhookInfo();

        $this->assertInstanceOf(WebhookInfo::class, $result);
        $this->assertSame('https://example.com/', $result->url);
    }

    public function testHideGeneralForumTopic(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->hideGeneralForumTopic(1);

        $this->assertTrue($result);
    }

    public function testLeaveChat(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->leaveChat(1);

        $this->assertTrue($result);
    }

    public function testLogOut(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->logOut();

        $this->assertTrue($result);
    }

    public function testPinChatMessage(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->pinChatMessage(1, 2);

        $this->assertTrue($result);
    }

    public function testPromoteChatMember(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->promoteChatMember(1, 2);

        $this->assertTrue($result);
    }

    public function testRefundStarPayment(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->refundStarPayment(1, 'test');

        $this->assertTrue($result);
    }

    public function testReopenForumTopic(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->reopenForumTopic(1, 2);

        $this->assertTrue($result);
    }

    public function testReopenGeneralForumTopic(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->reopenGeneralForumTopic(1);

        $this->assertTrue($result);
    }

    public function testReplaceStickerInSet(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->replaceStickerInSet(
            1,
            'test',
            'oldid',
            new InputSticker('https://example.com/sticker.webp', 'static', ['😀']),
        );

        $this->assertTrue($result);
    }

    public function testRestrictChatMember(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->restrictChatMember(1, 2, new ChatPermissions());

        $this->assertTrue($result);
    }

    public function testRevokeChatInviteLink(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'invite_link' => 'https//t.me/+example',
                'creator' => [
                    'id' => 23,
                    'is_bot' => true,
                    'first_name' => 'testBot',
                ],
                'creates_join_request' => true,
                'is_primary' => true,
                'is_revoked' => false,
            ],
        ]);

        $result = $api->revokeChatInviteLink(1, 'https//t.me/+example');

        $this->assertInstanceOf(ChatInviteLink::class, $result);
        $this->assertSame(23, $result->creator->id);
    }

    public function testSavePreparedInlineMessage(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'id' => 'test-id',
                'expiration_date' => 1620000000,
            ],
        ]);

        $result = $api->savePreparedInlineMessage(12, new InlineQueryResultGame('test', 'Hello'));

        $this->assertInstanceOf(PreparedInlineMessage::class, $result);
        $this->assertSame('test-id', $result->id);
    }

    public function testSendAnimation(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendAnimation(12, 'https://example.com/anime.gif');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendAudio(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendAudio(12, 'https://example.com/audio.mp3');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendChatAction(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->sendChatAction(12, 'typing');

        $this->assertTrue($result);
    }

    public function testSendContact(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendContact(12, '1234567890', 'John');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendDice(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendDice(12);

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendDocument(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendDocument(12, 'https://example.com/file.doc');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendGame(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendGame(12, 'The Stars');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendInvoice(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendInvoice(
            1,
            'The title',
            'The description',
            'The payload',
            'XTR',
            [],
        );

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendLocation(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendLocation(12, 1.1, 2.2);

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendMediaGroup(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                [
                    'message_id' => 7,
                    'date' => 1620000000,
                    'chat' => [
                        'id' => 1,
                        'type' => 'private',
                    ],
                ],
            ],
        ]);

        $result = $api->sendMediaGroup(12, []);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Message::class, $result[0]);
        $this->assertSame(7, $result[0]->messageId);
    }

    public function testSendMessage(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendMessage(12, 'hello');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendPaidMedia(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendPaidMedia(12, 25, []);

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendPhoto(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendPhoto(12, 'https://example.com/i.png');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendPoll(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendPoll(12, 'How are you?', []);

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendSticker(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendSticker(12, 'https://example.com/sticker.webp');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendVenue(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendVenue(12, 1.1, 2.2, 'title', 'address');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendVideo(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendVideo(12, 'https://example.com/wow.mp4');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }


    public function testSendVideoNote(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendVideoNote(12, 'https://example.com/wow.mp4');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSendVoice(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ]);

        $result = $api->sendVoice(12, 'https://example.com/wow.mp3');

        $this->assertInstanceOf(Message::class, $result);
        $this->assertSame(7, $result->messageId);
    }

    public function testSetChatAdministratorCustomTitle(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setChatAdministratorCustomTitle(1, 2, 'test');

        $this->assertTrue($result);
    }

    public function testSetChatPermissions(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setChatPermissions(1, new ChatPermissions());

        $this->assertTrue($result);
    }

    public function testSetChatDescription(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setChatDescription(12);

        $this->assertTrue($result);
    }

    public function testSetChatMenuButton(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setChatMenuButton();

        $this->assertTrue($result);
    }

    public function testSetChatPhoto(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setChatPhoto(12, new InputFile((new StreamFactory())->createStream()));

        $this->assertTrue($result);
    }

    public function testSetChatStickerSet(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setChatStickerSet(1, 'animals_by_bot');

        $this->assertTrue($result);
    }

    public function testSetChatTitle(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setChatTitle(12, 'test');

        $this->assertTrue($result);
    }

    public function testSetCustomEmojiStickerSetThumbnail(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setCustomEmojiStickerSetThumbnail('animals_by_my_bor');

        $this->assertTrue($result);
    }

    public function testSetGameScore(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setGameScore(1, 2);

        $this->assertTrue($result);
    }

    public function testSetMessageReaction(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setMessageReaction(12, 270);

        $this->assertTrue($result);
    }

    public function testSetMyCommands(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setMyCommands([
            new BotCommand('test', 'Test description'),
        ]);

        $this->assertTrue($result);
    }

    public function testSetMyDefaultAdministratorRights(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setMyDefaultAdministratorRights();

        $this->assertTrue($result);
    }

    public function testSetMyDescription(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setMyDescription();

        $this->assertTrue($result);
    }

    public function testSetMyName(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setMyName();

        $this->assertTrue($result);
    }

    public function testSetMyShortDescription(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setMyShortDescription();

        $this->assertTrue($result);
    }

    public function testSetPassportDataErrors(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setPassportDataErrors(1, []);

        $this->assertTrue($result);
    }

    public function testSetStickerEmojiList(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setStickerEmojiList('sid', ['😎']);

        $this->assertTrue($result);
    }

    public function testSetStickerKeywords(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setStickerKeywords('sid');

        $this->assertTrue($result);
    }

    public function testSetStickerMaskPosition(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setStickerMaskPosition('sid');

        $this->assertTrue($result);
    }

    public function testSetStickerPositionInSet(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setStickerPositionInSet('sid', 2);

        $this->assertTrue($result);
    }

    public function testSetStickerSetThumbnail(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setStickerSetThumbnail('animals_by_boy', 123, 'static');

        $this->assertTrue($result);
    }

    public function testSetStickerSetTitle(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setStickerSetTitle('name_by_bot', 'New Title');

        $this->assertTrue($result);
    }

    public function testSetUserEmojiStatus(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setUserEmojiStatus(19);

        $this->assertTrue($result);
    }

    public function testSetWebhook(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setWebhook('https://example.com/webhook');

        $this->assertTrue($result);
    }

    public function testStopMessageLiveLocation(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->stopMessageLiveLocation();

        $this->assertTrue($result);
    }

    public function testStopPoll(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'id' => '12',
                'question' => 'Why?',
                'options' => [
                    ['text' => 'One', 'voter_count' => 12],
                ],
                'total_voter_count' => 42,
                'is_closed' => true,
                'is_anonymous' => false,
                'type' => 'regular',
                'allows_multiple_answers' => true,
            ],
        ]);

        $result = $api->stopPoll(1, 2);

        $this->assertSame('12', $result->id);
    }

    public function testUnbanChatMember(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->unbanChatMember(1, 2);

        $this->assertTrue($result);
    }

    public function testUnbanChatSenderChat(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->unbanChatSenderChat(1, 2);

        $this->assertTrue($result);
    }

    public function testUnhideGeneralForumTopic(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->unhideGeneralForumTopic(1);

        $this->assertTrue($result);
    }

    public function testUnpinAllChatMessages(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->unpinAllChatMessages(2);

        $this->assertTrue($result);
    }

    public function testUnpinChatMessage(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->unpinChatMessage(2);

        $this->assertTrue($result);
    }

    public function testUnpinAllForumTopicMessages(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->unpinAllForumTopicMessages(1, 2);

        $this->assertTrue($result);
    }

    public function testUnpinAllGeneralForumTopicMessages(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->unpinAllGeneralForumTopicMessages(2);

        $this->assertTrue($result);
    }

    public function testUploadStickerFile(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'file_id' => 'f1',
                'file_unique_id' => 'fullX1',
                'file_size' => 123,
                'file_path' => 'path/to/file',
            ],
        ]);

        $result = $api->uploadStickerFile(1, new InputFile((new StreamFactory())->createStream()), 'static');

        $this->assertInstanceOf(File::class, $result);
        $this->assertSame('f1', $result->fileId);
    }

    private function createApi(
        array|string|TelegramResponse $response,
        int $statusCode = 200,
        ?LoggerInterface $logger = null,
    ): TelegramBotApi {
        return new TelegramBotApi(
            new StubTelegramClient(
                $response instanceof TelegramResponse
                    ? $response
                    : new TelegramResponse(
                        $statusCode,
                        is_array($response) ? json_encode($response) : $response,
                    ),
            ),
            $logger,
        );
    }
}
