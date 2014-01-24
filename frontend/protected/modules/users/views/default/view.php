<?php
/**
 * Страница одного пользователя.
 * @var yii\base\View $this
 * @var common\modules\users\models\User $model
 */

use yii\helpers\Html;

$this->title = $model->getFio(true);
$this->params['breadcrumbs'][] = $this->title;
$this->params['page-id'] = 'user';
?>
<h1><?php echo Html::encode($this->title); ?></h1>
<?= Html::img($model->avatar) ?>