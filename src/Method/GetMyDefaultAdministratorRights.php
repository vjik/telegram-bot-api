<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestInterface;
use Vjik\TelegramBot\Api\Type\ChatAdministratorRights;

/**
 * @see https://core.telegram.org/bots/api#getmydefaultadministratorrights
 *
 * @template-implements TelegramRequestInterface<class-string<ChatAdministratorRights>>
 */
final readonly class GetMyDefaultAdministratorRights implements TelegramRequestInterface
{
    public function __construct(
        private ?bool $forChannels = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getMyDefaultAdministratorRights';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'for_channels' => $this->forChannels,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): string
    {
        return ChatAdministratorRights::class;
    }
}
