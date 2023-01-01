<?php

namespace App\Enums;

enum PermissionName: string
{
    case USER_PROMOTE = 'user_promote';
    case USER_DEMOTE = 'user_demote';
    case ADD_PRODUCT = 'add_product';
    case DEL_PRODUCT = 'del_product';
    case LOGIN = 'login';
}
