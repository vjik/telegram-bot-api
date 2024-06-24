<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Client\TelegramResponse;
use Vjik\TelegramBot\Api\FailResult;
use Vjik\TelegramBot\Api\InvalidResponseFormatException;
use Vjik\TelegramBot\Api\Method\GetMe;
use Vjik\TelegramBot\Api\TelegramBotApi;
use Vjik\TelegramBot\Api\Tests\Support\StubTelegramClient;
use Vjik\TelegramBot\Api\Type\BotCommand;
use Vjik\TelegramBot\Api\Type\BotDescription;
use Vjik\TelegramBot\Api\Type\BotName;
use Vjik\TelegramBot\Api\Type\BotShortDescription;
use Vjik\TelegramBot\Api\Type\ChatFullInfo;
use Vjik\TelegramBot\Api\Type\File;
use Vjik\TelegramBot\Api\Type\MenuButtonDefault;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\MessageId;
use Vjik\TelegramBot\Api\Type\Payments\StarTransactions;
use Vjik\TelegramBot\Api\Type\User;
use Vjik\TelegramBot\Api\Type\UserProfilePhotos;
use Vjik\TelegramBot\Api\Type\Update\Update;
use Vjik\TelegramBot\Api\Type\Update\WebhookInfo;

final class TelegramBotApiTest extends TestCase
{
    public function testSendSuccess(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
        ]);

        $result = $api->send(new GetMe());

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame(1, $result->id);
    }

    public function testSendFail(): void
    {
        $api = $this->createApi([
            'ok' => false,
            'description' => 'test error',
        ]);

        $result = $api->send(new GetMe());

        $this->assertInstanceOf(FailResult::class, $result);
        $this->assertSame('test error', $result->description);
    }

    public function testSuccessResponseWithoutResult(): void
    {
        $api = $this->createApi([
            'ok' => true,
        ]);

        $this->expectException(InvalidResponseFormatException::class);
        $this->expectExceptionMessage('Not found "result" field in response. Status code: 200.');
        $api->send(new GetMe());
    }

    public function testResponseWithInvalidJson(): void
    {
        $api = $this->createApi('g {12}');

        $this->expectException(InvalidResponseFormatException::class);
        $this->expectExceptionMessage('Failed to decode JSON response. Status code: 200.');
        $api->send(new GetMe());
    }

    public function testNotArrayResponse(): void
    {
        $api = $this->createApi('"hello"');

        $this->expectException(InvalidResponseFormatException::class);
        $this->expectExceptionMessage('Expected telegram response as array. Got "string".');
        $api->send(new GetMe());
    }

    public function testResponseWithNotBooleanOk(): void
    {
        $api = $this->createApi([
            'ok' => 'true',
        ]);

        $this->expectException(InvalidResponseFormatException::class);
        $this->expectExceptionMessage('Incorrect "ok" field in response. Status code: 200.');
        $api->send(new GetMe());
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

    public function testDeleteMyCommands(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->deleteMyCommands();

        $this->assertTrue($result);
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

    public function testLogOut(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->logOut();

        $this->assertTrue($result);
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

    public function testSendMessages(): void
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

    public function testSetChatMenuButton(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setChatMenuButton();

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

    public function testSetWebhook(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->setWebhook('https://example.com/webhook');

        $this->assertTrue($result);
    }

    private function createApi(array|string $response, int $statusCode = 200): TelegramBotApi
    {
        return new TelegramBotApi(
            new StubTelegramClient(
                new TelegramResponse(
                    $statusCode,
                    is_array($response) ? json_encode($response) : $response,
                )
            )
        );
    }
}
