<?php 
use yii\rbac\Item;
use app\modules\users\models\User;

return array(
    'guest' => array(
        'type' => Item::TYPE_ROLE,
        'description' => 'Guest',
		'bizRule' => NULL,
        'data' => NULL
    ),
    User::ROLE_USER => array(
        'type' => Item::TYPE_ROLE,
        'description' => 'User',
        'children' => array(
            'guest',
            'editOwnProfile',
            'editOwnBlog',
            'editOwnComment',
            'deleteOwnProfile',
            'deleteOwnBlog',
            'deleteOwnComment'
        ),
        'bizRule' => 'return !Yii::$app->user->isGuest;',
        'data' => NULL
    ),
    User::ROLE_ADMIN => array(
        'type' => Item::TYPE_ROLE,
        'description' => 'Admin',
        'children' => array(
            User::ROLE_USER,
            'editProfile',
            'editBlog',
            'editComment',
            'deleteProfile',
            'deleteBlog',
            'deleteComment',
        ),
        'bizRule' => NULL,
        'data' => NULL
    ),
    'editOwnProfile' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Edit own profile',
        'bizRule' => 'return Yii::$app->user->identity->id == $params["user"]["id"];',
        'data' => NULL
    ),
    'editProfile' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Edit profile',
        'bizRule' => NULL,
        'data' => NULL
    ),
    'deleteOwnProfile' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Delete own profile',
        'bizRule' => 'return Yii::$app->user->identity->id == $params["user"]["id"];',
        'data' => NULL
    ),
    'deleteProfile' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Delete profile',
        'bizRule' => NULL,
        'data' => NULL
    ),
    'editOwnBlog' => array(
		'type' => Item::TYPE_TASK,
		'description' => 'Edit own post',
		'bizRule' => 'return Yii::$app->user->identity->id == $params["blog"]["author_id"];',
		'data' => NULL
	),
	'editBlog' => array(
		'type' => Item::TYPE_TASK,
		'description' => 'Edit post',
		'bizRule' => NULL,
		'data' => NULL
	),
    'deleteOwnBlog' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Delete own post',
        'bizRule' => 'return Yii::$app->user->identity->id == $params["blog"]["author_id"];',
        'data' => NULL
    ),
    'deleteBlog' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Delete post',
        'bizRule' => NULL,
        'data' => NULL
    ),
    'editOwnComment' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Edit own comment',
        'bizRule' => 'return Yii::$app->user->identity->id == $params["comment"]["author_id"];',
        'data' => NULL
    ),
    'editComment' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Edit comment',
        'bizRule' => NULL,
        'data' => NULL
    ),
    'deleteOwnComment' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Delete own comment',
        'bizRule' => 'return Yii::$app->user->identity->id == $params["comment"]["author_id"];',
        'data' => NULL
    ),
    'deleteComment' => array(
        'type' => Item::TYPE_TASK,
        'description' => 'Delete comment',
        'bizRule' => NULL,
        'data' => NULL
    )
);