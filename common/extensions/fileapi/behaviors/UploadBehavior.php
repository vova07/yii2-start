<?php
namespace common\extensions\fileapi\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\InvalidParamException;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\helpers\FileHelper;
use yii\validators\Validator;
use yii\web\UploadedFile;
use yii\web\Session;

/**
 * Class UploadBehavior
 * @package common\extensions\fileapi\behaviors
 * Поведение для загрузки файлов.
 * 
 * Пример использования:
 * ```
 * ...
 * 'uploadBehavior' => [
 *     'class' => UploadBehavior::className(),
 *     'attributes' => ['avatar_url'],
 *     'deleteScenarios' => [
 *         'avatar_url' => 'delete-avatar',
 *     ],
 *     'scenarios' => ['signup', 'update'],
 *     'path' => Yii::getAlias('@my/path'),
 *     'tempPath' => Yii::getAlias('@my/tempPath'),
 * ]
 * ...
 * ```
 */
class UploadBehavior extends Behavior
{
	/**
	 * @event Событие которое вызывается после успешной загрузки файла
	 */
	const EVENT_AFTER_UPLOAD = 'afterUpload';

	/**
	 * @var array Массив аттрибутов.
	 */
	public $attributes = [];

	/**
	 * @var array Массив сценариев в которых поведение должно срабатывать.
	 */
	public $scenarios = [];

	/**
	 * @var array Массив сценариев в которых нужно удалить указанные атрибуты и их файлы.
	 */
	public $deleteScenarios = [];

	/**
	 * @var string|array Путь к папке в которой будут загружены файлы.
	 */
	public $path;

	/**
	 * @var string|array Путь к временой папке в которой загружены файлы.
	 */
	public $tempPath;

	/**
	 * @var boolean В случае true текущий файл из атрибута модели будет удалён.
	 */
	public $deleteOnSave = true;

	/**
	 * @var array Массив событий поведения
	 */
	protected $_events = [
		ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
		ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
		ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',

	];

	/**
	 * @inheritdoc
	 */
	public function attach($owner)
	{
		parent::attach($owner);

		if (!is_array($this->attributes) || empty($this->attributes)) {
			throw new InvalidParamException("Invalid or empty \"{$this->attributes}\" array");
		}
		if (empty($this->path)) {
			throw new InvalidParamException("Empty \"{$this->path}\".");
		} else {
			if (is_array($this->path)) {
				foreach ($this->path as $attribute => $path) {
					$this->path[$attribute] = FileHelper::normalizePath($path) . DIRECTORY_SEPARATOR;
				}
			} else {
				$this->path = FileHelper::normalizePath($this->path) . DIRECTORY_SEPARATOR;
			}
		}
		if (empty($this->tempPath)) {
			throw new InvalidParamException("Empty \"{$this->tempPath}\".");
		} else {
			if (is_array($this->tempPath)) {
				foreach ($this->tempPath as $attribute => $path) {
					$this->tempPath[$attribute] = FileHelper::normalizePath($path) . DIRECTORY_SEPARATOR;
				}
			} else {
				$this->tempPath = FileHelper::normalizePath($this->tempPath) . DIRECTORY_SEPARATOR;
			}
		}
	}

	/**
	 * @inheritdoc
	 */
	public function events()
	{
		return $this->_events;
	}

	/**
	 * Функция срабатывает в момент создания новой записи моедли.
	 */
	public function beforeInsert()
	{
		if (in_array($this->owner->scenario, $this->scenarios) || empty($this->scenarios)) {
			foreach ($this->attributes as $attribute) {
				if ($this->owner->$attribute) {
					if (is_file($this->getTempPath($attribute))) {
						rename($this->getTempPath($attribute), $this->getPath($attribute));
						// Вызываем событие [[EVENT_AFTER_UPLOAD]]
						$this->triggerEventAfterUpload();
					} else {
						unset($this->owner->$attribute);
					}
				}
			}
		}
	}

	/**
	 * Функция срабатывает в момент обновления существующей записи моедли.
	 */
	public function beforeUpdate()
	{
		if (in_array($this->owner->scenario, $this->scenarios) || empty($this->scenarios)) {
			foreach ($this->attributes as $attribute) {
				if ($this->owner->isAttributeChanged($attribute)) {
					if (is_file($this->getTempPath($attribute))) {
						rename($this->getTempPath($attribute), $this->getPath($attribute));
						if ($this->deleteOnSave === true && $this->owner->getOldAttribute($attribute)) {
							$this->delete($attribute, true);
						}
						// Вызываем событие [[EVENT_AFTER_UPLOAD]]
						$this->triggerEventAfterUpload();
					} else {
						$this->owner->setAttribute($attribute, $this->owner->getOldAttribute($attribute));
					}
				}
			}
		}
		// Удаляем указаные атрибуты и их файлы если это нужно
		if (!empty($this->deleteScenarios) && in_array($this->owner->scenario, $this->deleteScenarios)) {
			foreach ($this->deleteScenarios as $attribute => $scenario) {
				if ($this->owner->scenario === $scenario) {
					$file = $this->getPath($attribute);
					if (is_file($file) && unlink($file)) {
						$this->owner->$attribute = null;
					}
				}
			}
		}
	}

	/**
	 * Функция срабатывает в момент удаления существующей записи моедли.
	 */
	public function beforeDelete()
	{
		foreach ($this->attributes as $attribute) {
			if ($this->owner->$attribute) {
				$this->delete($attribute);
			}
		}
	}

	/**
	 * Определяем событие [[EVENT_AFTER_UPLOAD]] для текущей модели.
	 */
	protected function triggerEventAfterUpload()
	{
		// $event = new ModelEvent;
		// $this->owner->trigger(self::EVENT_AFTER_UPLOAD, $event);
		$this->owner->trigger(self::EVENT_AFTER_UPLOAD);
	}

	/**
	 * Удаляем старый файл.
	 * @param string $fileName Имя файла.
	 */
	protected function delete($attribute, $old = false)
	{
		$file = $this->getPath($attribute, $old);
		if (is_file($file)) {
			unlink($file);
		}
	}

	/**
	 * @param string $attribute Атрибут для которого нужно вернуть путь загрузки.
	 * @return string Путь загрузки файла.
	 */
	public function getPath($attribute, $old = false)
	{
		if ($old === true) {
			$fileName = $this->owner->getOldAttribute($attribute);
		} else {
			$fileName = $this->owner->$attribute;
		}
		if (is_array($this->path) && isset($this->path[$attribute])) {
			$path = $this->path[$attribute];
		} else {
			$path = $this->path;
		}
		if (FileHelper::createDirectory($path)) {
			return $path . $fileName;
		}
		return null;
	}

	/**
	 * @param string $fileName Атрибут для которого нужно вернуть путь загрузки.
	 * @return string Временный путь загрузки файла.
	 */
	public function getTempPath($attribute)
	{
		$fileName = $this->owner->$attribute;
		if (is_array($this->tempPath) && isset($this->tempPath[$attribute])) {
			$path = $this->tempPath[$attribute];
		} else {
			$path = $this->tempPath;
		}
		return $path . $fileName;
	}
}