<?php
namespace common\extensions\fileapi;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use common\extensions\fileapi\assets\FileAPISingleAsset;
use common\extensions\fileapi\assets\FileAPIMultipleAsset;

/**
 * FileAPI Class
 * Виджет асинхроной загрузки файлов.
 * Работает на основе плагина {@link https://github.com/RubaXa/jquery.fileapi/ FileAPI}.
 * 
 * Пример использования:
 * ```
 * ...
 * echo FileAPI::widget([
 *     'name' => 'fileapi',
 *     'settings' => [
 *         'autoUpload' => true
 *     ]
 * ]);
 * ...
 * ```
 * или
 * ```
 * ...
 * echo $form->field($model, 'file')->widget(FileAPI::className(), [
 *     'settings' => [
 *         'autoUpload' => true
 *     ]
 * ]);
 * ...
 * ```
 */
class FileAPI extends InputWidget
{
	/**
	 * @var string Идентификатор шаблона с разметкой для плагина.
	 * Параметр позволяет инициализировать плагин виджета с собсвенной разметкой.
	 */
	public $selector;

	/**
	 * @var string Название файлового поля.
	 * Соответсвенно так же будет называтся $_FILES переменная с переданными файлами.
	 */
	public $fileVar = 'file';

	/**
	 * Настройки виджета
	 * @var array {@link https://github.com/RubaXa/jquery.fileapi/ FileAPI options}.
	 */
	public $settings = [];

	/**
	 * @var array Настройки виджета по умолчанию.
	 */
	protected $_defaultSettings;

	/**
	 * @var array Настройки по умолчанию для виджета с одиночной загрузкой.
	 */
	protected $_defaultSingleSettings = [
	    'autoUpload' => true,
	    'elements' => [
	    	'progress' => '.uploader-progress-bar',
	    	'active' => [
	    	    'show' => '.uploader-progress',
	    	    'hide' => '.uploader-browse'
	    	]
	    ]
	];

	/**
	 * @var array Настройки по умолчанию для мульти-загрузочного виджета.
	 */
	protected $_defaultMultipleSettings = [
	    'autoUpload' => true,
	    'elements' => [
	        'list' => '.uploader-files',
	        'file' => [
	        	'tpl' => '.uploader-file-tpl',
	        	'progress' => '.uploader-file-progress-bar',
	        	'preview' => [
	        		'el' => '.uploader-file-preview',
	        		'width' => 100,
	        		'height' => 100
	        	],
	        	'upload' => [
	        	    'show' => '.uploader-file-progress'
	        	],
	        	'complete' => [
	        	    'hide' => '.uploader-file-progress'
	        	]
	        ],
	        'dnd' => [
	            'el' => '.uploader-dnd',
	            'hover' => 'uploader-dnd-hover',
	            'fallback' => '.uploader-dnd-not-supported'
	        ]
	    ]
	];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		$request = Yii::$app->getRequest();
		// Регистрируем переводы виджета.
		$this->registerTranslations();
		// Если CSRF защита включена, добавляем токен в запросы виджета.
		if ($request->enableCsrfValidation) {
			$this->settings['data'][$request->csrfParam] = $request->getCsrfToken();
		}
		// Определяем URL загрузки файлов по умолчанию
		if (!isset($this->settings['url'])) {
			$this->settings['url'] = Yii::$app->getRequest()->getUrl();
		}
		// Определяем настройки по умолчанию
		if (isset($this->settings['multiple']) && $this->settings['multiple'] === true) {
			$this->_defaultSettings = $this->_defaultMultipleSettings;
		} else {
			$this->_defaultSettings = $this->_defaultSingleSettings;
		}
		// Определяем обработчики событий виджета
		$this->registerCallbacks();
		// Объединяем настройки виджета
		$this->settings = array_merge($this->_defaultSettings, $this->settings);
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$this->registerClientScript();
		if ($this->selector === null) {
			// Определяем тип загрузки
			if (isset($this->settings['multiple']) && $this->settings['multiple'] === true) {
				echo $this->render('multiple', ['selector' => $this->getId(), 'fileVar' => $this->fileVar]);
			} else {
				$input = $this->hasModel() ? Html::activeHiddenInput($this->model, $this->attribute, $this->options) : Html::hiddenInput($this->name, $this->value, $this->options);
				echo $this->render('single', ['selector' => $this->getId(), 'input' => $input, 'fileVar' => $this->fileVar]);
			}
		}
	}

	/**
	 * Регистрируем переводы виджета.
	 */
	public function registerTranslations()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['extensions/fileapi/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'ru',
            'basePath' => '@common/extensions/fileapi/messages',
            'fileMap' => [
                'extensions/fileapi/fileapi' => 'fileapi.php',
            ],
        ];
    }

    /**
     * Локальная функция перевода виджета.
     * @param string $category Категория перевода
     * @param string $message Сообщение которое нужно перевести
     * @param array $params Массив параметров которые будут заменены на их шаблоны в сообщении
     * @param string|null $language Язык перевода. В случае null, будет использован текущий [[\yii\base\Application::language|язык приложения]].
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('extensions/fileapi/' . $category, $message, $params, $language);
    }

	/**
	 * Регистрируем AssetBundle-ы виджета.
	 */
	public function registerClientScript()
	{
		$view = $this->getView();
		// Инициализируем плагин виджета
		$this->registerMainClientScript();
		// В случае мульти-загрузки добавляем индекс переменную.
		if (isset($this->settings['multiple']) && $this->settings['multiple'] === true) {
			// Регистрируем мульти-загрузочный бандл виджета
			FileAPIMultipleAsset::register($view);
			$view->registerJs("var indexKey = 0;");
		} else {
			// Регистрируем стандартный бандл виджета
			FileAPISingleAsset::register($view);
		}
	}

	/**
	 * Инициализируем Javascript плагин виджета
	 */
	protected function registerMainClientScript()
	{
		$view = $this->getView();
		$selector = ($this->selector !== null) ? '#' . $this->selector : '#' . $this->getId();
		$options = Json::encode($this->settings);
		// Инициализируем плагин виджета
		$view->registerJs("jQuery('$selector').fileapi($options);");
	}

	/**
	 * Определяем обработчики событий виджета.
	 */
	public function registerCallbacks()
	{
		// Определяем мульти-загрузку
		if (isset($this->settings['multiple']) && $this->settings['multiple'] === true) {
			$this->options['id'] = $this->options['id'] . '-{%key}';
			$this->options['value'] = '{%value}';
			$input = $this->hasModel() ? Html::activeHiddenInput($this->model, '[{%key}]' . $this->attribute, $this->options) : Html::hiddenInput('[{%key}]' . $this->name, $this->value, $this->options);
			$this->_defaultSettings['onFileComplete'] = new JsExpression("function (evt, uiEvt) {
				if (uiEvt.result.error) {
					alert(uiEvt.result.error);
				} else {
					var uinput = '$input',
					    uid = FileAPI.uid(uiEvt.file),
					    ureplace = {
					    	'{%key}' : indexKey,
					    	'{%value}' : uiEvt.result.name
					    };
					uinput = uinput.replace(/{%key}|{%value}/gi, function (index) {
						return ureplace[index];
					});
			        ufile = jQuery(this).find('div[data-fileapi-id=\"' + uid + '\"] .uploader-file-fields').html(uinput);
				}
			}");
		} else {
			$inputId = '#' . $this->options['id'];
			$this->_defaultSettings['onFileComplete'] = new JsExpression("function (evt, uiEvt) {
				if (uiEvt.result.error) {
					alert(uiEvt.result.error);
				} else {
					jQuery(this).find('$inputId').val(uiEvt.result.name);
				}
			}");
		}
	}
}