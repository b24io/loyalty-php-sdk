<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Result\Cards;

enum CardStatus: string
{
    case active = 'active';
    case blocked = 'blocked';
    case deleted = 'deleted';
}