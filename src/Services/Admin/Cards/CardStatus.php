<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Cards;

use B24io\Loyalty\SDK\Core\Result\AbstractResult;
use B24io\Loyalty\SDK\Services\Admin\Cards\Result\CardItemResult;

enum CardStatus: string
{
    case active = 'active';
    case blocked = 'blocked';
    case deleted = 'deleted';
}