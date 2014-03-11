<?php
/**
 * Представление отправки подвтерждения смены email адреса.
 * @var yii\web\View $this Представление 
 * @var string $key Ключ активации
 * @var string $email Email адрес
 */
 
use yii\helpers\Html;

$url = Yii::$app->urlManager->createAbsoluteUrl(['users/default/email', 'key' => $key, 'email' => $email]);
?>
<h3>Здравствуйте!</h3>
<p>Для того чтобы подтвердить смену email адреса вы должны перейти по ссылке: <?= Html::a(Html::encode($url), $url) ?>.</p>
