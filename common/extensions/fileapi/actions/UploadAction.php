<?php
namespace common\extensions\fileapi\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\validators\Validator;
use common\extensions\fileapi\models\Upload;

/**
 * UploadAction действие для загрузки файлов.
 * Использует в качестве валидаторов [[yii\validators\FileValidator]] или [[yii\validators\ImageValidator]],
 * таким образом доступны все параметры для настройки данных классов.
 * 
 * Пример использования:
 * ```
 * ...
 * 'uploadTempAvatar' => [
 *     'class' => UploadAction::className(),
 *     'path' => Yii::getAlias('@my/path'),
 *     'types' => ['jpg', 'png', 'gif'],
 *     'minHeight' => 100,
 *     'maxHeight' => 1000,
 *     'minWidth' => 100,
 *     'maxWidth' => 100,
 *     'maxSize' => 3145728 // 3*1024*1024 = 3MB
 * ]
 * ...
 * ```
 * 
 */
class UploadAction extends Action
{
	/**
	 * @var string По умолчанию используется [[yii\validators\ImageValidator]] в качестве основного валидатора загружаемых файлов.
	 * В случае false будет использоватся [[yii\validators\FileValidator]]
	 */
	public $imageValidator = true;

	/**
	 * @var string Путь к папке в которой будут загружены файлы
	 */
	public $path;

	/**
	 * @var string Название переменной в которой хранится загружаемый файл
	 */
	public $fileVar = 'file';

	/**
	 * @var boolean В случае true для загружаемых файлов будут сгенерированы уникальные имена на основе {@link http://md1.php.net/uniqid uniqid()}
	 */
	public $unique = true;

	/**
	 * @var array|string a list of file name extensions that are allowed to be uploaded.
	 * This can be either an array or a string consisting of file extension names
	 * separated by space or comma (e.g. "gif, jpg").
	 * Extension names are case-insensitive. Defaults to null, meaning all file name
	 * extensions are allowed.
	 * @see wrongType
	 */
	public $types;
	/**
	 * @var integer the minimum number of bytes required for the uploaded file.
	 * Defaults to null, meaning no limit.
	 * @see tooSmall
	 */
	public $minSize;
	/**
	 * @var integer the maximum number of bytes required for the uploaded file.
	 * Defaults to null, meaning no limit.
	 * Note, the size limit is also affected by 'upload_max_filesize' INI setting
	 * and the 'MAX_FILE_SIZE' hidden field value.
	 * @see tooBig
	 */
	public $maxSize;
	/**
	 * @var integer the maximum file count the given attribute can hold.
	 * It defaults to 1, meaning single file upload. By defining a higher number,
	 * multiple uploads become possible.
	 * @see tooMany
	 */
	public $maxFiles = 1;
	/**
	 * @var string the error message used when a file is not uploaded correctly.
	 */
	public $message;
	/**
	 * @var string the error message used when no file is uploaded.
	 */
	public $uploadRequired;
	/**
	 * @var string the error message used when the uploaded file is too large.
	 * You may use the following tokens in the message:
	 *
	 * - {attribute}: the attribute name
	 * - {file}: the uploaded file name
	 * - {limit}: the maximum size allowed (see [[getSizeLimit()]])
	 */
	public $tooBig;
	/**
	 * @var string the error message used when the uploaded file is too small.
	 * You may use the following tokens in the message:
	 *
	 * - {attribute}: the attribute name
	 * - {file}: the uploaded file name
	 * - {limit}: the value of [[minSize]]
	 */
	public $tooSmall;
	/**
	 * @var string the error message used when the uploaded file has an extension name
	 * that is not listed in [[types]]. You may use the following tokens in the message:
	 *
	 * - {attribute}: the attribute name
	 * - {file}: the uploaded file name
	 * - {extensions}: the list of the allowed extensions.
	 */
	public $wrongType;
	/**
	 * @var string the error message used if the count of multiple uploads exceeds limit.
	 * You may use the following tokens in the message:
	 *
	 * - {attribute}: the attribute name
	 * - {limit}: the value of [[maxFiles]]
	 */
	public $tooMany;
	/**
	 * @var string the error message used when the uploaded file is not an image.
	 * You may use the following tokens in the message:
	 *
	 * - {attribute}: the attribute name
	 * - {file}: the uploaded file name
	 */
	public $notImage;
	/**
	 * @var integer the minimum width in pixels.
	 * Defaults to null, meaning no limit.
	 * @see underWidth
	 */
	public $minWidth;
	/**
	 * @var integer the maximum width in pixels.
	 * Defaults to null, meaning no limit.
	 * @see overWidth
	 */
	public $maxWidth;
	/**
	 * @var integer the minimum height in pixels.
	 * Defaults to null, meaning no limit.
	 * @see underHeight
	 */
	public $minHeight;
	/**
	 * @var integer the maximum width in pixels.
	 * Defaults to null, meaning no limit.
	 * @see overWidth
	 */
	public $maxHeight;
	/**
	 * @var array|string a list of file mime types that are allowed to be uploaded.
	 * This can be either an array or a string consisting of file mime types
	 * separated by space or comma (e.g. "image/jpeg, image/png").
	 * Mime type names are case-insensitive. Defaults to null, meaning all mime types
	 * are allowed.
	 * @see wrongMimeType
	 */
	public $mimeTypes;
	/**
	 * @var string the error message used when the image is under [[minWidth]].
	 * You may use the following tokens in the message:
	 *
	 * - {attribute}: the attribute name
	 * - {file}: the uploaded file name
	 * - {limit}: the value of [[minWidth]]
	 */
	public $underWidth;
	/**
	 * @var string the error message used when the image is over [[maxWidth]].
	 * You may use the following tokens in the message:
	 *
	 * - {attribute}: the attribute name
	 * - {file}: the uploaded file name
	 * - {limit}: the value of [[maxWidth]]
	 */
	public $overWidth;
	/**
	 * @var string the error message used when the image is under [[minHeight]].
	 * You may use the following tokens in the message:
	 *
	 * - {attribute}: the attribute name
	 * - {file}: the uploaded file name
	 * - {limit}: the value of [[minHeight]]
	 */
	public $underHeight;
	/**
	 * @var string the error message used when the image is over [[maxHeight]].
	 * You may use the following tokens in the message:
	 *
	 * - {attribute}: the attribute name
	 * - {file}: the uploaded file name
	 * - {limit}: the value of [[maxHeight]]
	 */
	public $overHeight;
	/**
	 * @var string the error message used when the file has an mime type
	 * that is not listed in [[mimeTypes]].
	 * You may use the following tokens in the message:
	 *
	 * - {attribute}: the attribute name
	 * - {file}: the uploaded file name
	 * - {mimeTypes}: the value of [[mimeTypes]]
	 */
	public $wrongMimeType;

	/**
	 * @var string Имя валидатора
	 */
	protected $_validator;

	/**
	 * @var array Настройки валидатора
	 */
	protected $_validatorOptions;

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
		$this->_validatorOptions = [
			'types' => $this->types,
            'minSize' => $this->minSize,
            'maxSize' => $this->maxSize,
            'maxFiles' => $this->maxFiles,
            'message' => $this->message,
            'uploadRequired' => $this->uploadRequired,
            'tooBig' => $this->tooBig,
            'tooSmall' => $this->tooSmall,
            'wrongType' => $this->wrongType,
            'tooMany' => $this->tooMany
        ];
		if ($this->imageValidator === true) {
			$this->_validator = 'image';
			$this->_validatorOptions['notImage'] = $this->notImage;
			$this->_validatorOptions['minWidth'] = $this->minWidth;
			$this->_validatorOptions['maxWidth'] = $this->maxWidth;
			$this->_validatorOptions['minHeight'] = $this->minHeight;
			$this->_validatorOptions['maxHeight'] = $this->maxHeight;
			$this->_validatorOptions['mimeTypes'] = $this->mimeTypes;
			$this->_validatorOptions['underWidth'] = $this->underWidth;
			$this->_validatorOptions['overWidth'] = $this->overWidth;
			$this->_validatorOptions['underHeight'] = $this->underHeight;
			$this->_validatorOptions['overHeight'] = $this->overHeight;
			$this->_validatorOptions['wrongMimeType'] = $this->wrongMimeType;
		} else {
			$this->_validator = 'file';
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		if (Yii::$app->request->isPost) {
			$model = new Upload;
			// Определяем валидатор
			$validator = Validator::createValidator($this->_validator, $model, $model->attributes(), $this->_validatorOptions);
			// Добавляем валидатор
			$model->validators[] = $validator;
			// Присваиваем файл
			$model->file = UploadedFile::getInstanceByName($this->fileVar);
			if ($model->validate()) {
				if ($this->unique === true && $model->file->extension) {
					$model->file->name = uniqid() . '.' . $model->file->extension;
				}
				$model->file->saveAs($this->getSavePath($model->file->name));
				return Json::encode([
				    'name' => $model->file->name
				]);
			} else {
				return Json::encode([
					'error' => $model->getFirstError('file')
				]);
			}
		}
	}

	/**
	 * @param string Имя загружаемого файла.
	 * @return string Полный путь до папки куда нужно сохранить файл.
	 */
	protected function getSavePath($fileName)
	{
		if (FileHelper::createDirectory($this->path)) {
			return $this->path . $fileName;
		}
		return null;
	}
}