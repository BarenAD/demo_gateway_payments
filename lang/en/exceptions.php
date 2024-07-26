<?php

declare(strict_types=1);

return [
    'test' => [
        'message' => 'test_exception',
    ],
    'unauthorized' => [
        'message' => 'The user is not logged in.',
    ],
    'is_not_admin' => [
        'message' => 'The authorized user is not an administrator.',
    ],
    'not_enough_permissions' => [
        'message' => 'Insufficient administrative rights.',
    ],
    'invalid_login' => [
        'message' => 'Invalid username or password.',
    ],
    'user_already_exists' => [
        'message' => 'A user with such an e-mail or phone already exists.',
    ],
    'token_has_expired' => [
        'message' => 'The token\'s lifetime has expired.',
    ],
    'email_delay' => [
        'message' => 'Resending the Email will be available in :delay sec.',
    ],
    'email_already_verified' => [
        'message' => 'You have already verified this Email.',
    ],
    'identifier_expired' => [
        'message' => 'This identifier has expired.',
    ],
    'identifier_stolen' => [
        'message' => 'This identifier does not belong to you.',
    ],
    'user_is_not_confirmed_verification' => [
        'message' => 'The account was not verified. Access is denied.',
    ],
    'unique_constraint' => [
        'message' => 'This entity already exists.',
    ],
    'reserved_constraint' => [
        'message' => 'This entity/values are reserved by the system and cannot be edited or deleted!',
    ],
    'throttle_exception' => [
        'message' => 'Resending will be available in :delay seconds.',
    ],
    'without_invitation' => [
        'message' => 'Action is impossible without an invitation.',
    ],
    'without_accepted_invitation' => [
        'message' => 'Action is not possible until invitations are confirmed.',
    ],
    'not_found' => [
        'message' => 'not_found',
    ],
];
