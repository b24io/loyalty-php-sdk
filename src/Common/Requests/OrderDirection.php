<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Requests;

enum OrderDirection: string
{
    case asc = 'asc';
    case desc = 'desc';
}