<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport\MimeTypeResolver;

use Vjik\TelegramBot\Api\Type\InputFile;

/**
 * @api
 */
interface MimeTypeResolverInterface
{
    public function resolve(InputFile $file): ?string;
}
