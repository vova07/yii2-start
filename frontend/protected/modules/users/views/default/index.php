<?php
/**
 * Страница всех пользователей.
 * @var yii\base\View $this
 * @var common\modules\users\models\User $dataProvider
 */

use yii\helpers\Html;

$this->title = Yii::t('users', 'Пользователи');
$this->params['breadcrumbs'][] = $this->title;
$this->params['page-id'] = 'users';
?>
<h1><?php echo Html::encode($this->title); ?></h1>
<?= $this->render('_index_loop', [
	'dataProvider' => $dataProvider
]); ?>