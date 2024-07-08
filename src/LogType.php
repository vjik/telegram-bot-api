<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use Vjik\TelegramBot\Api\Client\TelegramResponse;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;

/**
 * @psalm-type SendRequestContext = array{
 *     type: LogType::SEND_REQUEST,
 *     request: TelegramRequestInterface,
 * }
 *
 * @psalm-type SuccessResultContext = array{
 *     type: LogType::SUCCESS_RESULT,
 *     request: TelegramRequestInterface,
 *     response: TelegramResponse,
 *     decodedResponse: mixed
 * }
 *
 * @psalm-type FailResultContext = array{
 *     type: LogType::FAIL_RESULT,
 *     request: TelegramRequestInterface,
 *     response: TelegramResponse,
 *     decodedResponse: mixed
 * }
 *
 * @psalm-type ParseResultErrorContext = array{
 *     type: LogType::PARSE_RESULT_ERROR,
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
        return [
            'type' => self::SEND_REQUEST,
            'request' => $request,
        ];
    }

    /**
     * @psalm-return SuccessResultContext
     */
    public static function createSuccessResultContext(
        TelegramRequestInterface $request,
        TelegramResponse $response,
        mixed $decodedResponse
    ): array {
        return [
            'type' => self::SUCCESS_RESULT,
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
        mixed $decodedResponse
    ): array {
        return [
            'type' => self::FAIL_RESULT,
            'request' => $request,
            'response' => $response,
            'decodedResponse' => $decodedResponse,
        ];
    }

    /**
     * @psalm-return ParseResultErrorContext
     */
    public static function createParseResultContext(string $raw): array
    {
        return [
            'type' => self::PARSE_RESULT_ERROR,
            'raw' => $raw,
        ];
    }
}
