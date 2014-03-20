<?php
namespace common\extensions\fileapi\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use common\extensions\fileapi\models\Upload;

/**
 * DeleteAction действие для удаления загруженных файлов.
 * 
 * Пример использования:
 * ```
 * ...
 * 'deleteTempAvatar' => [
 *     'class' => DeleteAction::className(),
 *     'path' => Yii::getAlias('@my/path'),
 * ]
 * ...
 * ```
 */
class DeleteAction extends Action
{
	/**
	 * @var string Путь к папке где хранятся файлы.
	 */
	public $path;

	/**
	 * @var string Название переменной в которой хранится имя файла.
	 */
	public $fileVar = 'file';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if ($this->path === null) {
			throw new InvalidConfigException("Empty \"{$this->path}\".");
		} else {
			$this->path = FileHelper::normalizePath($this->path) . DIRECTORY_SEPARATOR;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		if (($file = Yii::$app->request->getBodyParam($this->fileVar))) {
			if (is_file($this->path . $file)) {
				unlink($this->path . $file);
			}
		}
	}
}