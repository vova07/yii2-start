<?php
namespace common\helpers;

/**
 * Text helper
 */
class TextHelper
{

	/**
	 * Очищаем входной код от HTML тэгов
	 * @param string $text Код который нужно очистить
	 * @param integer $maxchar максимальное количество допустимых символов
	 * @param string $termination строка которая добавляется в конце обработаного текста
	 * @param string $encoding кодировка текста
	 * @return string обработаная строка
	 */
	public static function snippet($text, $maxchar = 90, $termination = '...', $encoding = 'utf-8')
	{
		$text = strip_tags(trim($text));
		if ($maxchar > 0 && mb_strlen($text) > $maxchar) {
			$text = mb_substr($text, 0, $maxchar, $encoding);
			if ($termination) {
				$text .= $termination;
			}
		}
		return $text;
	}
}