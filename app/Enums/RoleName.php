<?php

namespace App\Enums;

enum RoleName: string
{
    case ADMIN = 'admin';
    case SELLER = 'seller';
    case CUSTOMER = 'customer';
}
