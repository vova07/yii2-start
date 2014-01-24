<?php
namespace common\extensions\tinymce;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use common\extensions\tinymce\assets\TinymceAsset;

/**
 * Tinymce Widget Class
 * Wysiwyg редактор на основе плагина {@link http://www.tinymce.com Tinymce}.
 * 
 * Пример использования редактора с привязкой к модели:
 * ```php
 * ...
 * echo $form->field($model, 'text')->widget(Tinymce::className(), [
 *     'settings' => [
 *         'language' => 'ru'
 *     ]
 * ]);
 * ...
 * ```
 * 
 * Пример использования редактора независимо от модели:
 * ```php
 * ...
 * echo Tinymce::widget([
 *     'name' => 'redactor'
 * ]);
 * ...
 * ```
 * 
 * Пример использования редактора с привязкой к уже существующему элементу:
 * ```php
 * ...
 * <textarea id="textarea"></textarea>
 * ...
 * 
 * echo Tinymce::widget([
 *     'name' => 'redactor',
 *     'settings' => [
 *         'selector' => '#textarea'
 *     ]
 * ]);
 * ...
 * ```
 *
 * @property array $options Настройки редактора.
 * @property array $htmlOptions HTML настройки textarea.
 * @property array $_defaultOptions Настройки редактора по умолчанию.
 * @property yii\helpers\Html $_textarea Textarea виджета.
 */
class Tinymce extends InputWidget
{
	/**
	 * Настройки редактора
	 * @var array {@link http://www.tinymce.com/wiki.php/Configuration redactor options}.
	 */
	public $settings = [];

	/**
	 * @var boolean Определяем настройки по умолчанию для редактора в зависимости от типа пользователя.
	 */
	public $admin = false;

	/**
	 * @var array|null Настройки редактора по умолчанию.
	 */
	protected $_defaultSettings;

	/**
	 * @var array Настройки редактора по умолчанию для простых пользователей.
	 */
	protected $_defaultStandartSettings = [
	    'language' => 'ru',
	    'relative_urls' => false,
	    'height' => '200px',
	    'menubar' => false,
	    'statusbar' => false,
	    'plugins' => ['advlist autolink link image lists hr table'],
	    'toolbar' => 'bold italic underline strikethrough | bullist numlist | link unlink image | hr table blockquote | pagebreak'
	];

	/**
	 * @var array Настройки редактора по умолчанию для простых пользователей.
	 */
	protected $_defaultAdvancedSettings = [
	    'language' => 'ru',
	    'relative_urls' => false,
	    'height' => '200px',
	    'menubar' => false,
	    'statusbar' => false,
	    'plugins' => ['advlist autolink link image lists hr table pagebreak code'],
	    'toolbar' => 'bold italic underline strikethrough | bullist numlist | link unlink image | hr table blockquote | pagebreak code'
	];

	/**
	 * @var yii\helpers\Html textarea
	 */
	private $_textarea;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		// if (!isset($this->options['selector']) || !isset($this->htmlOptions['id'])) {
		// Определяем идентификатор поля редактора.
		if (!isset($this->options['id'])) {
			$this->options['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
		}
		// Добавляем поле для редактора, и определяем нужный селектор.
		if (!isset($this->settings['selector'])) {
			$this->settings['selector'] = '#' . $this->options['id'];

			if ($this->hasModel()) {
				$this->_textarea = Html::activeTextarea($this->model, $this->attribute, $this->options);
			} else {
				$this->_textarea = Html::textarea($this->name, $this->value, $this->options);
			}
		}
		/* Если [[options['selector']]] указан как false удаляем селектор из настроек.
		   Это обычно нужно для динамической инициализации виджета */
		if (isset($this->settings['selector']) && $this->settings['selector'] === false) {
			unset($this->settings['selector']);
		}
		// }
		if ($this->admin !== false) {
			$this->_defaultSettings = $this->_defaultAdvancedSettings;
		} else {
			$this->_defaultSettings = $this->_defaultStandartSettings;
		}
		$this->settings = array_merge($this->_defaultSettings, $this->settings);
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		if ($this->_textarea !== null) {
			echo $this->_textarea;
		}
		$this->registerClientScript();
	}

	/**
	 * Регистрируем AssetBundle-ы виджета.
	 */
	public function registerClientScript()
	{
		$view = $this->getView();
		$settings = Json::encode($this->settings);
		TinymceAsset::register($view);
		$view->registerJs("tinymce.init($settings);");
	}
}