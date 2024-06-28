<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Constant;

/**
 * @see https://core.telegram.org/bots/api#formatting-options
 */
final class ParseMode
{
    const MARKDOWN_V2 = 'MarkdownV2';
    const HTML = 'HTML';

    /**
     * @deprecated Use self::MARKDOWN_V2 instead.
     */
    const MARKDOWN = 'Markdown';
}
