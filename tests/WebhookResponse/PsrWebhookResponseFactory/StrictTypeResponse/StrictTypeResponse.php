<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\WebhookResponse\PsrWebhookResponseFactory\StrictTypeResponse;

use HttpSoft\Message\ResponseTrait;
use LogicException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

use function is_string;

final class StrictTypeResponse implements ResponseInterface
{
    use ResponseTrait {
        withHeader as protected traitWithHeader;
    }

    /**
     * @param StreamInterface|string|resource|null $body
     */
    public function __construct(
        int $statusCode = 200,
        string $reasonPhrase = '',
        array $headers = [],
        mixed $body = null,
        string $protocol = '1.1',
    ) {
        $this->init($statusCode, $reasonPhrase, $headers, $body, $protocol);
    }

    public function withHeader(string $name, $value): MessageInterface
    {
        $this->checkValue($value);
        return $this->traitWithHeader($name, $value);
    }

    /**
     * Validate that header values are strings, not integers or other types.
     * This catches the mutant where (string) cast is removed from $body->getSize().
     *
     * @throws LogicException if value is not a string or array of strings
     */
    private function checkValue($value): void
    {
        if (is_string($value)) {
            return;
        }

        throw new LogicException(
            'Invalid header value: expected string, got ' . get_debug_type($value),
        );
    }
}
