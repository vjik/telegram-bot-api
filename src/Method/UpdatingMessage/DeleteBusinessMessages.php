<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\UpdatingMessage;

use Vjik\TelegramBot\Api\MethodInterface;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

/**
 * @see https://core.telegram.org/bots/api#deletebusinessmessages
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class DeleteBusinessMessages implements MethodInterface
{
    /**
     * @param int[] $messageIds
     */
    public function __construct(
        private string $businessConnectionId,
        private array $messageIds,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteBusinessMessages';
    }

    public function getData(): array
    {
        return [
            'business_connection_id' => $this->businessConnectionId,
            'message_ids' => $this->messageIds,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
