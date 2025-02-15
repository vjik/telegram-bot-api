<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Support;

use Psr\Log\LoggerInterface;
use Vjik\TelegramBot\Api\Transport\ApiResponse;
use Vjik\TelegramBot\Api\TelegramBotApi;

final readonly class TestHelper
{
    public static function createSuccessStubApi(
        mixed $result,
        ?LoggerInterface $logger = null,
    ): TelegramBotApi {
        $response = $result instanceof ApiResponse
            ? $result
            : new ApiResponse(
                200,
                json_encode(['ok' => true, 'result' => $result], JSON_THROW_ON_ERROR),
            );
        return new TelegramBotApi(
            'stub-token',
            transport: new TransportMock($response),
            logger: $logger,
        );
    }
}
