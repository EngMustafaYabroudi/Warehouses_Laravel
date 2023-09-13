<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadministrator' => [
            'users' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'admins' => 'c,r,u,d',
            'category' => 'c,r,u,d',
            'product' => 'c,r,u,d',
            'settings' => 'c,r,u,d',
            'employees' => 'c,r,u,d',
            'storehouses' => 'c,r,u,d',
        ],
        'administrator' => [
            
            'storehouses_management' => 'c,r,u,d',
        ],
        'user' => [
            
        ],
        
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
