<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#menubuttonwebapp
 */
final readonly class MenuButtonWebApp implements MenuButton
{
    public function __construct(
        public string $text,
        public WebAppInfo $webApp,
    ) {
    }

    public function getType(): string
    {
        return 'web_app';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'text' => $this->text,
            'web_app' => $this->webApp->toRequestArray(),
        ];
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'text', $raw),
            array_key_exists('web_app', $result)
                ? WebAppInfo::fromTelegramResult($result['web_app'], $raw)
                : throw new NotFoundKeyInResultException('web_app', $raw),
        );
    }
}
