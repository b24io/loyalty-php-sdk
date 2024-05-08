<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common;

enum Gender: string
{
    case male = 'male';
    case female = 'female';
    case unknown = 'unknown';
}