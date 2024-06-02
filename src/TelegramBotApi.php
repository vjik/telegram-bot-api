<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use JsonException;
use Vjik\TelegramBot\Api\Client\TelegramResponse;
use Vjik\TelegramBot\Api\Method\DeleteMyCommands;
use Vjik\TelegramBot\Api\Method\GetChat;
use Vjik\TelegramBot\Api\Method\GetMe;
use Vjik\TelegramBot\Api\Method\GetMyCommands;
use Vjik\TelegramBot\Api\Method\GetMyDescription;
use Vjik\TelegramBot\Api\Method\GetMyName;
use Vjik\TelegramBot\Api\Method\GetMyShortDescription;
use Vjik\TelegramBot\Api\Method\SendMessage;
use Vjik\TelegramBot\Api\Method\SetMyCommands;
use Vjik\TelegramBot\Api\Method\SetMyDescription;
use Vjik\TelegramBot\Api\Method\SetMyName;
use Vjik\TelegramBot\Api\Method\SetMyShortDescription;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Client\TelegramClientInterface;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\BotCommand;
use Vjik\TelegramBot\Api\Type\BotCommandScope;
use Vjik\TelegramBot\Api\Type\BotDescription;
use Vjik\TelegramBot\Api\Type\BotName;
use Vjik\TelegramBot\Api\Type\BotShortDescription;
use Vjik\TelegramBot\Api\Type\ChatFullInfo;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\LinkPreviewOptions;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\ReplyKeyboardRemove;
use Vjik\TelegramBot\Api\Type\ReplyParameters;
use Vjik\TelegramBot\Api\Type\ResponseParameters;
use Vjik\TelegramBot\Api\Type\User;

final class TelegramBotApi
{
    public function __construct(
        private TelegramClientInterface $telegramClient,
    ) {
    }

    /**
     * @see https://core.telegram.org/bots/api#making-requests
     */
    public function send(TelegramRequestInterface $request): mixed
    {
        $response = $this->telegramClient->send($request);

        try {
            $decodedBody = json_decode($response->body, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidResponseFormatException(
                'Failed to decode JSON response. Status code: ' . $response->statusCode,
                previous: $e
            );
        }

        if (!is_array($decodedBody)) {
            throw new TelegramRuntimeException(
                'Expected telegram response as array. Got ' . get_debug_type($decodedBody) . '.'
            );
        }

        if (!isset($decodedBody['ok']) || !is_bool($decodedBody['ok'])) {
            throw new InvalidResponseFormatException(
                'Incorrect "ok" field in response. Status code: ' . $response->statusCode,
            );
        }

        return $decodedBody['ok']
            ? $this->prepareSuccessResult($request, $response, $decodedBody)
            : $this->prepareFailResult($request, $response, $decodedBody);
    }

    /**
     * @see https://core.telegram.org/bots/api#deletemycommands
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function deleteMyCommands(?BotCommandScope $scope = null, ?string $languageCode = null): FailResult|true
    {
        return $this->send(new DeleteMyCommands($scope, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchat
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getChat(int|string $chatId): FailResult|ChatFullInfo
    {
        return $this->send(new GetChat($chatId));
    }

    /**
     * @see https://core.telegram.org/bots/api#getchat
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getMe(): FailResult|User
    {
        return $this->send(new GetMe());
    }

    /**
     * @see https://core.telegram.org/bots/api#getmycommands
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getMyCommands(?BotCommandScope $scope = null, ?string $languageCode = null): FailResult|array
    {
        return $this->send(new GetMyCommands($scope, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmydescription
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getMyDescription(?string $languageCode = null): FailResult|BotDescription
    {
        return $this->send(new GetMyDescription($languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmyname
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getMyName(?string $languageCode = null): FailResult|BotName
    {
        return $this->send(new GetMyName($languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#getmyshortdescription
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function getMyShortDescription(?string $languageCode = null): FailResult|BotShortDescription
    {
        return $this->send(new GetMyShortDescription($languageCode));
    }

    /**
     * @param MessageEntity[]|null $entities
     *
     * @see https://core.telegram.org/bots/api#sendmessage
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function sendMessages(
        int|string $chatId,
        string $text,
        ?string $businessConnectionId = null,
        ?int $messageThreadId = null,
        ?string $parseMode = null,
        ?array $entities = null,
        ?LinkPreviewOptions $linkPreviewOptions = null,
        ?bool $disableNotification = null,
        ?bool $protectContent = null,
        ?string $messageEffectId = null,
        ?ReplyParameters $replyParameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $replyMarkup = null,
    ): FailResult|Message {
        return $this->send(
            new SendMessage(
                $chatId,
                $text,
                $businessConnectionId,
                $messageThreadId,
                $parseMode,
                $entities,
                $linkPreviewOptions,
                $disableNotification,
                $protectContent,
                $messageEffectId,
                $replyParameters,
                $replyMarkup,
            )
        );
    }

    /**
     * @param BotCommand[] $commands
     *
     * @see https://core.telegram.org/bots/api#setmycommands
     */
    public function setMyCommands(
        array $commands,
        ?BotCommandScope $scope = null,
        ?string $languageCode = null,
    ): FailResult|true {
        return $this->send(new SetMyCommands($commands, $scope, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmydescription
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setMyDescription(?string $description = null, ?string $languageCode = null): FailResult|true
    {
        return $this->send(new SetMyDescription($description, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmyname
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setMyName(?string $name = null, ?string $languageCode = null): FailResult|true
    {
        return $this->send(new SetMyName($name, $languageCode));
    }

    /**
     * @see https://core.telegram.org/bots/api#setmyshortdescription
     *
     * @psalm-suppress MixedInferredReturnType,MixedReturnStatement
     */
    public function setMyShortDescription(
        ?string $shortDescription = null,
        ?string $languageCode = null
    ): FailResult|true {
        return $this->send(new SetMyShortDescription($shortDescription, $languageCode));
    }

    private function prepareSuccessResult(
        TelegramRequestInterface $request,
        TelegramResponse $response,
        array $decodedBody
    ): mixed {
        if (!array_key_exists('result', $decodedBody)) {
            throw new InvalidResponseFormatException(
                'Not found "result" field in response. Status code: ' . $response->statusCode,
            );
        }

        return $request instanceof TelegramRequestWithResultPreparingInterface
            ? $request->prepareResult($decodedBody['result'])
            : $decodedBody['result'];
    }

    private function prepareFailResult(
        TelegramRequestInterface $request,
        TelegramResponse $response,
        array $decodedBody
    ): FailResult {
        return new FailResult(
            (isset($decodedBody['description']) && is_string($decodedBody['description']))
                ? $decodedBody['description']
                : null,
            $decodedBody['error_code'] ?? null,
            ResponseParameters::fromDecodedBody($decodedBody),
            $request,
            $response,
        );
    }
}
