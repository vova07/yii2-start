<?php
namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\HtmlPurifier;

/**
 * Class PurifierBehavior
 * Данное поведение очищает от небезопастного кода указаные в настройках атрибуты.
 * 
 * Пример использования:
 * ```
 * ...
 * 'purifier' => [
 *     'class' => 'common\behaviors\PurifierBehavior',
 *     'attributes' => [
 *         ActiveRecord::EVENT_BEFORE_UPDATE => ['content'],
 *         ActiveRecord::EVENT_BEFORE_INSERT => ['content'],
 *     ],
 *     'textAttributes' => [
 *         ActiveRecord::EVENT_BEFORE_UPDATE => ['title'],
 *         ActiveRecord::EVENT_BEFORE_INSERT => ['title'],
 *     ]
 * ]
 * ...
 * ```
 * 
 * @property array $attributes массив атрибутов которые доступны в поведении.
 * @property array $purifierOptions массив с настройками HtmlPurifier.
 */
class PurifierBehavior extends Behavior
{
	/**
	 * @var array Массив аттрибутов которые должны быть обработаны с HtmlPurifier
	 */
	public $attributes = [];

	/**
	 * @var array Массив аттрибутов которые должны быть полностью очищены с HtmlPurifier от HTML тэгов и небезопастного кода
	 */
	public $textAttributes = [];

	/**
	 * @var array Массив с конфигами для каждого аттрибута
	 */
	public $purifierOptions = [];

	/**
	 * @return array Массив с дефолтной конфигурацией
	 */
	public static function defaultPurifierOptions()
	{
		return [
			'AutoFormat.RemoveEmpty' => true,
			'AutoFormat.RemoveEmpty.RemoveNbsp' => true,
			'AutoFormat.Linkify' => true,
			'HTML.Nofollow' => true
		];
	}


	/**
	 * Назначаем обработчик для [[owner]] событий.
	 * @return array События (array keys) с назначеными им обработчиками (array values).
	 */
	public function events()
	{
		foreach ($this->attributes as $i => $event) {
			$events[$i] = 'purify';
		}
		foreach ($this->textAttributes as $i => $event) {
			$events[$i] = 'textPurify';
		}
		return $events;
	}

	/**
	 * Очищаем атрибуты с указаными настройками.
	 * @param Event $event Текущее событие.
	 */
	public function purify($event)
	{
		$attributes = isset($this->attributes[$event->name]) ? (array)$this->attributes[$event->name] : [];
		if (!empty($attributes)) {
			$purifier = new HtmlPurifier;
			foreach ($attributes as $attribute) {
				$options = isset($this->purifierOptions[$attribute]) ? $this->purifierOptions[$attribute] : $this->defaultPurifierOptions();
				$this->owner->$attribute = $purifier->process($this->owner->$attribute, $options);
			}
		}
	}

	/**
	 * Очищаем атрибуты от всего HTML кода.
	 * @param Event $event Текущее событие.
	 */
	public function textPurify($event)
	{
		$attributes = isset($this->textAttributes[$event->name]) ? (array)$this->textAttributes[$event->name] : [];
		if (!empty($attributes)) {
			$purifier = new HtmlPurifier;
			foreach ($attributes as $attribute) {
				$options = [
				    'HTML.AllowedElements' => '',
				    'AutoFormat.RemoveEmpty' => true,
				    'AutoFormat.RemoveEmpty.RemoveNbsp' => true,
				];
				$this->owner->$attribute = $purifier->process($this->owner->$attribute, $options);
			}
		}
	}
}