<?php
namespace frontend\modules\comments;

use Yii;

/**
 * Frontend-модуль [[Comments]]
 */
class Comments extends \common\modules\comments\Comments
{
	/**
	 * @var integer Масимальный визуальный уровень вложености комментариев.
	 */
	public $maxLevel = 6;
}