<?php
return array (
  'createPost' => 
  array (
    'type' => 0,
    'description' => 'Cоздание записи',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewPost' => 
  array (
    'type' => 0,
    'description' => 'Просмотр записи',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updatePost' => 
  array (
    'type' => 0,
    'description' => 'Редактирование записи',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deletePost' => 
  array (
    'type' => 0,
    'description' => 'Удаление записи',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'createComment' => 
  array (
    'type' => 0,
    'description' => 'Cоздание комментария',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'viewComment' => 
  array (
    'type' => 0,
    'description' => 'Просмотр комментария',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateComment' => 
  array (
    'type' => 0,
    'description' => 'Редактирование комментария',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deleteComment' => 
  array (
    'type' => 0,
    'description' => 'Удаление комментария',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateUser' => 
  array (
    'type' => 0,
    'description' => 'Редактирование пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deleteUser' => 
  array (
    'type' => 0,
    'description' => 'Удаление пользователя',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'updateOwnPost' => 
  array (
    'type' => 1,
    'description' => 'Редактирование своей записи',
    'bizRule' => 'return Yii::$app->user->id === $params["model"]["author_id"];',
    'data' => NULL,
  ),
  'deleteOwnPost' => 
  array (
    'type' => 1,
    'description' => 'Удаление своей записи',
    'bizRule' => 'return Yii::$app->user->id === $params["model"]["author_id"];',
    'data' => NULL,
  ),
  'updateOwnComment' => 
  array (
    'type' => 1,
    'description' => 'Редактирование своего комментария',
    'bizRule' => 'return Yii::$app->user->id === $params["model"]["author_id"];',
    'data' => NULL,
  ),
  'deleteOwnComment' => 
  array (
    'type' => 1,
    'description' => 'Удаление своего комментария',
    'bizRule' => 'return Yii::$app->user->id === $params["model"]["author_id"];',
    'data' => NULL,
  ),
  'guest' => 
  array (
    'type' => 2,
    'description' => 'Гость',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'viewPost',
      1 => 'viewComment',
    ),
  ),
  0 => 
  array (
    'type' => 2,
    'description' => 'Пользователь',
    'bizRule' => 'return !Yii::$app->user->isGuest;',
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
    'type' => 2,
    'description' => 'Модератор',
    'bizRule' => NULL,
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
    'type' => 2,
    'description' => 'Администратор',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 3,
    ),
  ),
  2 => 
  array (
    'type' => 2,
    'description' => 'Супер-администратор',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 1,
    ),
  ),
);
