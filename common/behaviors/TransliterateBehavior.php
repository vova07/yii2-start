<?php
namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use common\helpers\TransliterateHelper;

/**
 * Class TransliterateBehavior
 * Данное поведение позволяет транслировать атрибуты с кирилицы на латынь.
 * Обыно используется для алиасов модели.
 * 
 * Пример использования:
 * ```
 * ...
 * 'transliterate' => [
 *     'class' => 'common\behaviors\TransliterateBehavior',
 *     'attributes' => [
 *         ActiveRecord::EVENT_BEFORE_INSERT => [
 *             'title' => 'alias'
 *         ],
 *         ActiveRecord::EVENT_BEFORE_UPDATE => [
 *             'title' => 'alias'
 *         ]
 *     ]
 * ]
 * ...
 * ```
 * 
 * @property array $attributes Массив атрибутов которые нужно обработать.
 */
class TransliterateBehavior extends Behavior
{
	/**
	 * @var array Массив аттрибутов которые должны быть обработаны.
	 */
	public $attributes = [];

	/**
	 * @var boolean true для того чтобы привести строку в нижний регистр.
	 */
	public $toLowCase = true;

	/**
	 * Назначаем обработчик для [[owner]] событий.
	 * @return array события (array keys) с назначеными им обработчиками (array values).
	 */
	public function events()
	{
		$events = $this->attributes;
		foreach ($events as $i => $event) {
			$events[$i] = 'transliterate';
		}
		return $events;
	}

	/**
	 * Очищаем атрибуты.
	 * @param Event $event Текущее событие.
	 */
	public function transliterate($event)
	{
		$attributes = isset($this->attributes[$event->name]) ? (array)$this->attributes[$event->name] : [];
		if (!empty($attributes)) {
			foreach ($attributes as $source => $attribute) {
				$this->owner->$attribute = TransliterateHelper::cyrillicToLatin($this->owner->$source);
			}
		}
	}
}