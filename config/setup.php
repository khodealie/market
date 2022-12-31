<?php
return [
    'PERMISSIONS' => [
        'USER_PROMOTE' => 'user_promote',
        'USER_DEMOTE' => 'user_demote',
        'ADD_PRODUCT' => 'add_product',
        'DEL_PRODUCT' => 'del_product',
        'LOGIN' => 'login'
    ],
    'ROLES' => [
        'ADMIN' => [
            'NAME' => 'admin',
            'PERMISSIONS' => ['USER_PROMOTE', 'USER_DEMOTE', 'ADD_PRODUCT', 'DEL_PRODUCT', 'LOGIN']
        ],
        'SELLER' => [
            'NAME' => 'seller',
            'PERMISSIONS' => ['ADD_PRODUCT', 'DEL_PRODUCT', 'LOGIN']
        ],
        'CUSTOMER' => [
            'NAME' => 'customer',
            'PERMISSIONS' => ['LOGIN']
        ]
    ]
];
