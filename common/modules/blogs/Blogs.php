<?php
namespace common\modules\blogs;

use Yii;
use yii\base\Module;

/**
 * Общий модуль [[Blogs]]
 */
class Blogs extends Module
{
	/**
	 * @var integer Количество записей на главной странице модуля.
	 */
	public $recordsPerPage = 5;

	/**
	 * @var array Массив доступных для загрузки расширений изображений.
	 */
	public $imageAllowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

	/**
	 * @var array Массив доступных для загрузки расширений мини-изображений.
	 */
	public $previewAllowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

	/**
	 * @var integer Ширина изображения поста.
	 */
	public $imageWidth = 400;

	/**
	 * @var integer Высота изображения поста.
	 */
	public $imageHeight = 300;

	/**
	 * @var integer Ширина мини-изображения поста.
	 */
	public $previewWidth = 160;

	/**
	 * @var integer Высота мини-изображения поста.
	 */
	public $previewHeight = 120;

	/**
	 * @param string $image Имя изображения
	 * @return string Путь к папке где хранятся изображения постов.
	 */
	public function imagePath($image = null)
	{
		$path = '@root/statics/web/content/blogs/images';
		if ($image !== null) {
			$path .= '/' . $image;
		}
		return Yii::getAlias($path);
	}

	/**
	 * @param string $image Имя изображения
	 * @return string Путь к временной папке где хранятся изображения постов или путь к конкретному изображению
	 */
	public function imageTempPath($image = null)
	{
		$path = '@root/statics/tmp/blogs/images';
		if ($image !== null) {
			$path .= '/' . $image;
		}
		return Yii::getAlias($path);
	}

	/**
	 * @param string $image Имя изображения
	 * @return string Путь к папке где хранятся мини-изображения постов.
	 */
	public function previewPath($image = null)
	{
		$path = '@root/statics/web/content/blogs/previews';
		if ($image !== null) {
			$path .= '/' . $image;
		}
		return Yii::getAlias($path);
	}

	/**
	 * @param string $image Имя изображения
	 * @return string Путь к временной папке где хранятся мини-изображения постов или путь к конкретному мини-изображению
	 */
	public function previewTempPath($image = null)
	{
		$path = '@root/statics/tmp/blogs/previews';
		if ($image !== null) {
			$path .= '/' . $image;
		}
		return Yii::getAlias($path);
	}

	/**
	 * @param string $image Имя изображения.
	 * @return string URL к папке где хранится/хранятся изображение/я.
	 */
	public function imageUrl($image = null)
	{
		$url = '/content/blogs/images/';
		if ($image !== null) {
			$url .= $image;
		}
		if (isset(Yii::$app->params['staticsDomain'])) {
			$url = Yii::$app->params['staticsDomain'] . $url;
		}
		return $url;
	}

	/**
	 * @param string $image Имя изображения.
	 * @return string URL к папке где хранится/хранятся мини-изображение/я.
	 */
	public function previewUrl($image = null)
	{
		$url = '/content/blogs/previews/';
		if ($image !== null) {
			$url .= $image;
		}
		if (isset(Yii::$app->params['staticsDomain'])) {
			$url = Yii::$app->params['staticsDomain'] . $url;
		}
		return $url;
	}
}