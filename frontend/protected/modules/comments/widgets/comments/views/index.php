<?php
/**
 * Представление блока комментариев.
 * @var yii\base\View $this Представление
 * @var common\modules\comments\models\Comment $model Модель нового комментария
 * @var common\modules\comments\models\Comment $models Массив моделей
 * @var string $title Заголовок виджета
 * @var integer $level Уровень вложености комментария
 * @var integer $maxLevel максимальный уровень вложености комментариев
 */
?>
<div id="comments-widget">
    <h3><?= $title ?></h3>
    <?php if (Yii::$app->user->can('createComment')) { ?>
        <a href="#" class="btn btn-default create"><?= $createButtonTxt ?></a>
    <?php } ?>
    <div class="comments">
	    <?= $this->render('_index_loop', [
	    	'models' => $models,
	    	'level' => $level,
	    	'maxLevel' => $maxLevel
	    ]) ?>
    </div>
    <?php if (Yii::$app->user->can('createComment')) { ?>
        <div class="hide">
            <?= $this->render('_form', [
                'model' => $model,
                'sendButtonText' => $sendButtonText,
                'cancelButtonText' => $cancelButtonText
            ]) ?>
        </div>
    <?php } ?>
</div>