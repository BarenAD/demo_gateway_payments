<?php

declare(strict_types=1);

return [
    'test' => [
        'message' => 'тестовая_ошибка',
    ],
    'unauthorized' => [
        'message' => 'Пользователь не авторизован.',
    ],
    'is_not_admin' => [
        'message' => 'Авторизованный пользователь не является администратором.',
    ],
    'not_enough_permissions' => [
        'message' => 'Недостаточно прав администрирования.',
    ],
    'invalid_login' => [
        'message' => 'Неверный логин или пароль.',
    ],
    'user_already_exists' => [
        'message' => 'Пользователь с таким e-mail или телефоном уже существует.',
    ],
    'token_has_expired' => [
        'message' => 'Время жизни токена истекло.',
    ],
    'email_delay' => [
        'message' => 'Повторная отправка Email будет доступна через :delay сек.',
    ],
    'email_already_verified' => [
        'message' => 'Вы уже верифицировали этот Email.',
    ],
    'identifier_expired' => [
        'message' => 'Данный идентификатор устарел.',
    ],
    'identifier_stolen' => [
        'message' => 'Данный идентификатор принадлежит не вам.',
    ],
    'user_is_not_confirmed_verification' => [
        'message' => 'Аккаунт не прошёл верификацию. Доступ запрещён.',
    ],
    'unique_constraint' => [
        'message' => 'Данная сущность уже существует.',
    ],
    'reserved_constraint' => [
        'message' => 'Данная сущность/значения зарезервированны системой и не подлежат редактированию или удалению!',
    ],
    'throttle_exception' => [
        'message' => 'Повторная отправка будет доступна через :delay сек.',
    ],
    'without_invitation' => [
        'message' => 'Действие невозможно без приглашения.',
    ],
    'without_accepted_invitation' => [
        'message' => 'Действие невозможно пока не подтвердждены приглашения.',
    ],
    'not_found' => [
        'message' => 'Не найдено',
    ],
];
