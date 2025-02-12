<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\Sticker\Gift;

/**
 * @see https://core.telegram.org/bots/api#transactionpartnerchat
 *
 * @api
 */
final readonly class TransactionPartnerChat implements TransactionPartner
{
    public function __construct(
        public Chat $chat,
        public ?Gift $gift = null,
    ) {}

    public function getType(): string
    {
        return 'chat';
    }
}
