<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#keyboardbutton
 */
final readonly class KeyboardButton
{
    public function __construct(
        public string $text,
        public ?KeyboardButtonRequestUsers $requestUsers = null,
        public ?KeyboardButtonRequestChat $requestChat = null,
        public ?bool $requestContact = null,
        public ?bool $requestLocation = null,
        public ?KeyboardButtonPollType $requestPoll = null,
        public ?WebAppInfo $webApp = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'text' => $this->text,
                'request_users' => $this->requestUsers?->toRequestArray(),
                'request_chat' => $this->requestChat?->toRequestArray(),
                'request_contact' => $this->requestContact,
                'request_location' => $this->requestLocation,
                'request_poll' => $this->requestPoll?->toRequestArray(),
                'web_app' => $this->webApp?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
