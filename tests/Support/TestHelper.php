<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Support;

use Vjik\TelegramBot\Api\Transport\ApiResponse;
use Vjik\TelegramBot\Api\TelegramBotApi;

final class TestHelper
{
    public static function createSuccessStubApi(mixed $result): TelegramBotApi
    {
        return new TelegramBotApi(
            new StubTransport(
                new ApiResponse(
                    200,
                    json_encode([
                        'ok' => true,
                        'result' => $result,
                    ]),
                ),
            ),
        );
    }
}
