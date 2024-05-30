<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use JsonException;
use Vjik\TelegramBot\Api\Client\TelegramResponse;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Client\TelegramClientInterface;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\ResponseParameters;

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
