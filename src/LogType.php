<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use JsonException;
use Vjik\TelegramBot\Api\Transport\ApiResponse;

/**
 * @psalm-type ParseResultErrorContext = array{
 *     type: LogType::PARSE_RESULT_ERROR,
 *     payload: string
 * }
 */
final readonly class LogType
{
    public const SEND_REQUEST = 1;
    public const SUCCESS_RESULT = 2;
    public const FAIL_RESULT = 3;
    public const PARSE_RESULT_ERROR = 4;

    /**
     * @psalm-return array{
     *     type: LogType::SEND_REQUEST,
     *     payload: array<string, mixed>,
     *     method: MethodInterface,
     * }
     */
    public static function createSendRequestContext(MethodInterface $method): array
    {
        return [
            'type' => self::SEND_REQUEST,
            'payload' => $method->getData(),
            'method' => $method,
        ];
    }

    /**
     * @psalm-return array{
     *     type: LogType::SUCCESS_RESULT,
     *     payload: array,
     *     method: MethodInterface,
     *     response: ApiResponse,
     *     decodedResponse: array,
     * }
     */
    public static function createSuccessResultContext(
        MethodInterface $method,
        ApiResponse $response,
        array $decodedResponse,
    ): array {
        return [
            'type' => self::SUCCESS_RESULT,
            'payload' => $decodedResponse,
            'method' => $method,
            'response' => $response,
            'decodedResponse' => $decodedResponse,
        ];
    }

    /**
     * @psalm-return array{
     *     type: LogType::FAIL_RESULT,
     *     payload: string,
     *     method: MethodInterface,
     *     response: ApiResponse,
     *     decodedResponse: array,
     * }
     */
    public static function createFailResultContext(
        MethodInterface $method,
        ApiResponse $response,
        array $decodedResponse,
    ): array {
        return [
            'type' => self::FAIL_RESULT,
            'payload' => $response->body,
            'method' => $method,
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
