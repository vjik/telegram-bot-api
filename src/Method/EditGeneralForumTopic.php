<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#editgeneralforumtopic
 */
final readonly class EditGeneralForumTopic implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private string $name,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'editGeneralForumTopic';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'name' => $this->name,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
