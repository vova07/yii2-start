<?php
return array (
  'items' => 
  array (
    'createPost' => 
    array (
      'type' => 2,
      'description' => 'Cоздание записи',
      'ruleName' => NULL,
      'data' => NULL,
    ),
    'viewPost' => 
    array (
      'type' => 2,
      'description' => 'Просмотр записи',
      'ruleName' => NULL,
      'data' => NULL,
    ),
    'updatePost' => 
    array (
      'type' => 2,
      'description' => 'Редактирование записи',
      'ruleName' => NULL,
      'data' => NULL,
    ),
    'deletePost' => 
    array (
      'type' => 2,
      'description' => 'Удаление записи',
      'ruleName' => NULL,
      'data' => NULL,
    ),
    'createComment' => 
    array (
      'type' => 2,
      'description' => 'Cоздание комментария',
      'ruleName' => NULL,
      'data' => NULL,
    ),
    'viewComment' => 
    array (
      'type' => 2,
      'description' => 'Просмотр комментария',
      'ruleName' => NULL,
      'data' => NULL,
    ),
    'updateComment' => 
    array (
      'type' => 2,
      'description' => 'Редактирование комментария',
      'ruleName' => NULL,
      'data' => NULL,
    ),
    'deleteComment' => 
    array (
      'type' => 2,
      'description' => 'Удаление комментария',
      'ruleName' => NULL,
      'data' => NULL,
    ),
    'updateUser' => 
    array (
      'type' => 2,
      'description' => 'Редактирование пользователя',
      'ruleName' => NULL,
      'data' => NULL,
    ),
    'deleteUser' => 
    array (
      'type' => 2,
      'description' => 'Удаление пользователя',
      'ruleName' => NULL,
      'data' => NULL,
    ),
    'updateOwnPost' => 
    array (
      'type' => 2,
      'description' => 'Редактирование своей записи',
      'ruleName' => 'author',
      'data' => NULL,
    ),
    'deleteOwnPost' => 
    array (
      'type' => 2,
      'description' => 'Удаление своей записи',
      'ruleName' => 'author',
      'data' => NULL,
    ),
    'updateOwnComment' => 
    array (
      'type' => 2,
      'description' => 'Редактирование своего комментария',
      'ruleName' => 'author',
      'data' => NULL,
    ),
    'deleteOwnComment' => 
    array (
      'type' => 2,
      'description' => 'Удаление своего комментария',
      'ruleName' => 'author',
      'data' => NULL,
    ),
    'guest' => 
    array (
      'type' => 1,
      'description' => 'Гость',
      'ruleName' => NULL,
      'data' => NULL,
      'children' => 
      array (
        0 => 'viewPost',
        1 => 'viewComment',
      ),
    ),
    0 => 
    array (
      'type' => 1,
      'description' => 'Пользователь',
      'ruleName' => 'notGuestRule',
      'data' => NULL,
      'children' => 
      array (
        0 => 'guest',
        1 => 'createPost',
        2 => 'updateOwnPost',
        3 => 'deleteOwnPost',
        4 => 'createComment',
        5 => 'updateOwnComment',
        6 => 'deleteOwnComment',
      ),
    ),
    3 => 
    array (
      'type' => 1,
      'description' => 'Модератор',
      'ruleName' => NULL,
      'data' => NULL,
      'children' => 
      array (
        0 => 0,
        1 => 'updatePost',
        2 => 'deletePost',
        3 => 'updateComment',
        4 => 'deleteComment',
      ),
    ),
    1 => 
    array (
      'type' => 1,
      'description' => 'Администратор',
      'ruleName' => NULL,
      'data' => NULL,
      'children' => 
      array (
        0 => 3,
      ),
    ),
    2 => 
    array (
      'type' => 1,
      'description' => 'Супер-администратор',
      'ruleName' => NULL,
      'data' => NULL,
      'children' => 
      array (
        0 => 1,
      ),
      'assignments' => 
      array (
        1 => 
        array (
          'roleName' => 2,
        ),
      ),
    ),
  ),
  'rules' => 
  array (
    'notGuestRule' => 'O:52:"common\\modules\\users\\modules\\rbac\\rules\\NotGuestRule":3:{s:4:"name";s:12:"notGuestRule";s:9:"createdAt";N;s:9:"updatedAt";N;}',
    'author' => 'O:50:"common\\modules\\users\\modules\\rbac\\rules\\AuthorRule":3:{s:4:"name";s:6:"author";s:9:"createdAt";N;s:9:"updatedAt";N;}',
  ),
);
