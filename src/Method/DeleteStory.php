<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#deletestory
 *
 * @template-implements MethodInterface<true>
 *
 * @api
 */
final readonly class DeleteStory implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private int $storyId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteStory';
    }

    public function getData(): array
    {
        return [
            'business_connection_id' => $this->businessConnectionId,
            'story_id' => $this->storyId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
