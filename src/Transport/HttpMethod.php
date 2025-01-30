<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport;

/**
 * @api
 */
enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
}
