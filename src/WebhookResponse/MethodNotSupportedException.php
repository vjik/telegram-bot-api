<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\WebhookResponse;

use LogicException;

/**
 * Exception thrown when a method doesn't support sending via a webhook response.
 *
 * @api
 */
final class MethodNotSupportedException extends LogicException {}
