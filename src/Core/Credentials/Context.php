<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Credentials;

enum Context: string
{
    case admin = 'admin';
    case user = 'user';
}