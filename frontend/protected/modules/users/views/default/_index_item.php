<?php
/**
 * Шаблон одного пользователя на странице всех записей.
 * @var yii\base\View $this
 * @var common\modules\users\models\User $model
 */

use yii\helpers\Html;
?>
<div class="user-avatar">
    <?= Html::a(Html::img($model->avatar), ['view', 'username' => $model['username']]) ?>
</div>
<h3><?= Html::a($model->fio, ['view', 'username' => $model['username']]) ?></h3>