<?php

use yii\rbac\Item;
use common\modules\users\modules\rbac\rules\NotGuestRule;
use common\modules\users\modules\rbac\rules\AuthorRule;

$notGuest = new NotGuestRule();
$author = new AuthorRule();

return [
    'rules' => [
        $notGuest->name => serialize($notGuest),
        $author->name => serialize($author)
    ],
    'items' => [
        // Tasks
        'createPost' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Cоздание записи',
            'ruleName' => null,
            'data' => null
        ],
        'viewPost' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Просмотр записи',
            'ruleName' => null,
            'data' => null
        ],
        'updatePost' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Редактирование записи',
            'ruleName' => null,
            'data' => null
        ],
        'deletePost' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Удаление записи',
            'ruleName' => null,
            'data' => null
        ],
        'createComment' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Cоздание комментария',
            'ruleName' => null,
            'data' => null
        ],
        'viewComment' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Просмотр комментария',
            'ruleName' => null,
            'data' => null
        ],
        'updateComment' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Редактирование комментария',
            'ruleName' => null,
            'data' => null
        ],
        'deleteComment' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Удаление комментария',
            'ruleName' => null,
            'data' => null
        ],
        'updateUser' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Редактирование пользователя',
            'ruleName' => null,
            'data' => null
        ],
        'deleteUser' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Удаление пользователя',
            'ruleName' => null,
            'data' => null
        ],
        'updateOwnPost' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Редактирование своей записи',
            'ruleName' => $author->name,
            'data' => null
        ],
        'deleteOwnPost' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Удаление своей записи',
            'ruleName' => $author->name,
            'data' => null
        ],
        'updateOwnComment' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Редактирование своего комментария',
            'ruleName' => $author->name,
            'data' => null
        ],
        'deleteOwnComment' => [
            'type' => Item::TYPE_OPERATION,
            'description' => 'Удаление своего комментария',
            'ruleName' => $author->name,
            'data' => null
        ],
        // Roles
        'guest' => [
            'type' => Item::TYPE_ROLE,
            'description' => 'Гость',
            'children' => [
                'viewPost',
                'viewComment'
            ],
            'ruleName' => null,
            'data' => null
        ],
        0 => [
            'type' => Item::TYPE_ROLE,
            'description' => 'Пользователь',
            'children' => [
                'guest',
                'createPost',
                'updateOwnPost',
                'deleteOwnPost',
                'createComment',
                'updateOwnComment',
                'deleteOwnComment'
            ],
            'ruleName' => $notGuest->name,
            'data' => null
        ],
        3 => [
            'type' => Item::TYPE_ROLE,
            'description' => 'Модератор',
            'children' => [
                0,
                'updatePost',
                'deletePost',
                'updateComment',
                'deleteComment'
            ],
            'ruleName' => null,
            'data' => null
        ],
        1 => [
            'type' => Item::TYPE_ROLE,
            'description' => 'Администратор',
            'children' => [
                3
            ],
            'ruleName' => null,
            'data' => null
        ],
        2 => [
            'type' => Item::TYPE_ROLE,
            'description' => 'Супер-администратор',
            'children' => [
                1
            ],
            'ruleName' => null,
            'data' => null
        ],
    ]
];
