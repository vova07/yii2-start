<?php 
namespace common\extensions\fileapi\models;

use Yii;
use yii\base\Model;

/**
 * Class Upload
 * @package common\extensions\fileapi\models
 * Загрузочная модель файлов.
 */
class Upload extends Model
{
	/**
	 * Переменные используются для сбора пользовательской информации, но не сохраняются в базу.
	 * @var yii\web\UploadedFile переданный файл/ы
	 */
	public $file;
}