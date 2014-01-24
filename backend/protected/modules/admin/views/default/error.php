<?php
/**
 * Представление страницы ошибок.
 * @var yii\base\View $this Предсталвение
 * @var string $name Название
 * @var string $message Сообщение
 * @var Exception $exception Исключение
 */

use yii\helpers\Html;

$this->title = $name; ?>
<div class="site-error">
    <h1><?php echo Html::encode($this->title); ?></h1>
	<div class="alert alert-danger">
		<?php echo nl2br(Html::encode($message)); ?>
	</div>
</div>