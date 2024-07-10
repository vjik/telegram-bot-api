<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use JsonException;
use Vjik\TelegramBot\Api\Client\TelegramResponse;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;

/**
 * @psalm-type SendRequestContext = array{
 *     type: LogType::SEND_REQUEST,
 *     payload: string,
 *     request: TelegramRequestInterface,
 * }
 *
 * @psalm-type SuccessResultContext = array{
 *     type: LogType::SUCCESS_RESULT,
 *     payload: string,
 *     request: TelegramRequestInterface,
 *     response: TelegramResponse,
 *     decodedResponse: mixed
 * }
 *
 * @psalm-type FailResultContext = array{
 *     type: LogType::FAIL_RESULT,
 *     payload: string,
 *     request: TelegramRequestInterface,
 *     response: TelegramResponse,
 *     decodedResponse: mixed
 * }
 *
 * @psalm-type ParseResultErrorContext = array{
 *     type: LogType::PARSE_RESULT_ERROR,
 *     payload: string,
 *     raw: string
 * }
 */
final readonly class LogType
{
    public const SEND_REQUEST = 1;
    public const SUCCESS_RESULT = 2;
    public const FAIL_RESULT = 3;
    public const PARSE_RESULT_ERROR = 4;

    /**
     * @psalm-return SendRequestContext
     */
    public static function createSendRequestContext(TelegramRequestInterface $request): array
    {
        try {
            $payload = json_encode($request->getData(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        } catch (JsonException) {
            $payload = '%UNABLE_DATA%';
        }
        return [
            'type' => self::SEND_REQUEST,
            'payload' => $payload,
            'request' => $request,
        ];
    }

    /**
     * @psalm-return SuccessResultContext
     */
    public static function createSuccessResultContext(
        TelegramRequestInterface $request,
        TelegramResponse $response,
        mixed $decodedResponse,
    ): array {
        try {
            $payload = json_encode($decodedResponse, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        } catch (JsonException) {
            $payload = $response->body;
        }
        return [
            'type' => self::SUCCESS_RESULT,
            'payload' => $payload,
            'request' => $request,
            'response' => $response,
            'decodedResponse' => $decodedResponse,
        ];
    }

    /**
     * @psalm-return FailResultContext
     */
    public static function createFailResultContext(
        TelegramRequestInterface $request,
        TelegramResponse $response,
        mixed $decodedResponse,
    ): array {
        return [
            'type' => self::FAIL_RESULT,
            'payload' => $response->body,
            'request' => $request,
            'response' => $response,
            'decodedResponse' => $decodedResponse,
        ];
    }

    /**
     * @psalm-return ParseResultErrorContext
     */
    public static function createParseResultErrorContext(string $raw): array
    {
        return [
            'type' => self::PARSE_RESULT_ERROR,
            'payload' => $raw,
        ];
    }
}
