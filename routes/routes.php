<?php

use App\Enums\UserTypeEnum;

return [
    ['path' => '/api/v1/auth/login',                 'method' => 'POST', 'public' => true,  'permissions' => [], 'roles' => []],
    ['path' => '/api/v1/auth/refresh',               'method' => 'POST', 'public' => false, 'permissions' => [], 'roles' => []],
    ['path' => '/api/v1/auth/register/patient',      'method' => 'POST', 'public' => true,  'permissions' => [], 'roles' => []],
    ['path' => '/api/v1/auth/register/doctor',       'method' => 'POST', 'public' => true,  'permissions' => [], 'roles' => []],
    ['path' => '/api/v1/auth/register/assistant',    'method' => 'POST', 'public' => true,  'permissions' => [], 'roles' => []],
    ['path' => '/api/v1/auth/logout',                'method' => 'POST', 'public' => false, 'permissions' => [], 'roles' => []],

    ['path' => '/api/v1/users/me',                   'method' => 'GET',  'public' => false, 'permissions' => [], 'roles' => []],
    ['path' => '/api/v1/users/me/profile/patient',   'method' => 'PUT',  'public' => false, 'permissions' => [], 'roles' => [UserTypeEnum::USER->value, UserTypeEnum::PATIENT->value]],
    ['path' => '/api/v1/users/me/profile/doctor',    'method' => 'PUT',  'public' => false, 'permissions' => [], 'roles' => [UserTypeEnum::USER->value, UserTypeEnum::DOCTOR->value]],
    ['path' => '/api/v1/users/me/profile/assistant', 'method' => 'PUT',  'public' => false, 'permissions' => [], 'roles' => [UserTypeEnum::USER->value, UserTypeEnum::ASSISTANT->value]],
    ['path' => '/api/v1/users/me/password',          'method' => 'PUT',  'public' => false, 'permissions' => [], 'roles' => [UserTypeEnum::ADMIN->value]],

    ['path' => '/api/v1/users/all/admins',               'method' => 'GET',  'public' => false, 'permissions' => [], 'roles' => [UserTypeEnum::ADMIN->value]],
    ['path' => '/api/v1/users/all/doctors',              'method' => 'GET',  'public' => false, 'permissions' => [], 'roles' => [UserTypeEnum::USER->value]],
    ['path' => '/api/v1/users/all/assistants',           'method' => 'GET',  'public' => false, 'permissions' => [], 'roles' => [UserTypeEnum::USER->value]],
    ['path' => '/api/v1/users/all/patients',             'method' => 'GET',  'public' => false, 'permissions' => [], 'roles' => [UserTypeEnum::USER->value]],
    ['path' => '/api/v1/users/{id}',                 'method' => 'GET',  'public' => false, 'permissions' => [], 'roles' => [UserTypeEnum::USER->value]],
    ['path' => '/api/v1/users/{id}/status',          'method' => 'PUT',  'public' => false, 'permissions' => [], 'roles' => [UserTypeEnum::ADMIN->value]],
    ['path' => '/api/v1/users/{id}/roles',           'method' => 'POST', 'public' => false, 'permissions' => [], 'roles' => [UserTypeEnum::ADMIN->value]],
];
