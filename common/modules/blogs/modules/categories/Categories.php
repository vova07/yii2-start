<?php
namespace common\modules\blogs\modules\categories;

use Yii;
use yii\base\Module;

/**
 * Модуль [[Categories]]
 * Данный моделуь осуществляет всю работу с категориями блогов
 */
class Categories extends Module
{
	/**
	 * Локальная функция перевода модуля
	 * @param string $message
	 * @param array $params
	 * @param string $category
	 * @param string $language
	 * @return string перевод $message на нужный язык
	 */
	public static function t($message, $params = array(), $category = 'post-categories', $language = '') {
		if (empty($language)) {
			$language = Yii::$app->language;
		}
		return Yii::t($category, $message, $params, $language);
	}
}