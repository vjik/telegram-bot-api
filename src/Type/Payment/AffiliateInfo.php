<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#affiliateinfo
 *
 * @api
 */
final readonly class AffiliateInfo
{
    public function __construct(
        public int $commissionPerMille,
        public int $amount,
        public ?int $nanostarAmount = null,
        public ?User $affiliateUser = null,
        public ?Chat $affiliateChat = null,
    ) {}
}
