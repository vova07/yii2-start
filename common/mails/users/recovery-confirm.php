<?php
/**
 * Представление отправки подвтерждения восстановления пароля.
 * @var yii\web\View $this Представление 
 * @var string $key Ключ активации
 * @var string $email Email адрес
 */

use yii\helpers\Html;

$url = Yii::$app->urlManager->createAbsoluteUrl(['users/default/recoveryPassword', 'key' => $key, 'email' => $email]);
?>
<h3>Здравствуйте!</h3>
<p>Для того чтобы подвтердить смену пароля, вы должны перейти по ссылке: <?= Html::a(Html::encode($url), $url) ?>.</p>