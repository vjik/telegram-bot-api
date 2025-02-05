<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\Type\BusinessConnection;

/**
 * @see https://core.telegram.org/bots/api#getbusinessconnection
 *
 * @template-implements MethodInterface<BusinessConnection>
 */
final readonly class GetBusinessConnection implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getBusinessConnection';
    }

    public function getData(): array
    {
        return [
            'business_connection_id' => $this->businessConnectionId,
        ];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(BusinessConnection::class);
    }
}
