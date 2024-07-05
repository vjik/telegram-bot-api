<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendPoll;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InputPollOption;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendPollTest extends TestCase
{
    public function testBase(): void
    {
        $option1 = new InputPollOption('OK');
        $option2 = new InputPollOption('Bad');
        $method = new SendPoll(12, 'How are you?', [$option1, $option2]);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendPoll', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'question' => 'How are you?',
                'options' => [
                    ['text' => 'OK'],
                    ['text' => 'Bad'],
                ],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $option1 = new InputPollOption('OK');
        $option2 = new InputPollOption('Bad');
        $messageEntity1 = new MessageEntity('bold', 0, 5);
        $messageEntity2 = new MessageEntity('bold', 1, 3);
        $date = new DateTimeImmutable();
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendPoll(
            12,
            'How are you?',
            [$option1, $option2],
            'bcid1',
            3462,
            'HTML',
            [$messageEntity1],
            true,
            'quiz',
            false,
            23,
            'Good explanation',
            'Markdown',
            [$messageEntity2],
            300,
            $date,
            true,
            false,
            false,
            'meid2',
            $replyParameters,
            $replyMarkup,
        );

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendPoll', $method->getApiMethod());
        $this->assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_thread_id' => 3462,
                'question' => 'How are you?',
                'question_parse_mode' => 'HTML',
                'question_entities' => [$messageEntity1->toRequestArray()],
                'options' => [
                    ['text' => 'OK'],
                    ['text' => 'Bad'],
                ],
                'is_anonymous' => true,
                'type' => 'quiz',
                'allows_multiple_answers' => false,
                'correct_option_id' => 23,
                'explanation' => 'Good explanation',
                'explanation_parse_mode' => 'Markdown',
                'explanation_entities' => [$messageEntity2->toRequestArray()],
                'open_period' => 300,
                'close_date' => $date->getTimestamp(),
                'is_closed' => true,
                'disable_notification' => false,
                'protect_content' => false,
                'message_effect_id' => 'meid2',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendPoll(12, 'How are you?', []);

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->send($method);

        $this->assertSame(7, $preparedResult->messageId);
    }
}
