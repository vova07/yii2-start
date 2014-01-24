<?php
namespace common\extensions\fileapi;

use Yii;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\web\JsExpression;
use common\extensions\fileapi\assets\FileAPIAvatarAsset;

/**
 * FileAPIAvatar Class
 * Виджет асинхроной загрузки аватар-ов.
 * Работает на основе плагина {@link https://github.com/RubaXa/jquery.fileapi/ FileAPI}.
 */
class FileAPIAvatar extends FileAPI
{
	/**
	 * @var string URL для удаления текущего аватар-а.
	 */
	public $deleteUrl;

	/**
	 * @var boolean Показывать или нет преьвю загружаемой картинки.
	 */
	public $withPreview = false;

	/**
	 * @var string Ссылка на текущий аватар.
	 */
	public $previewUrl;

	/**
	 * @var array Настройки виджета по умолчанию
	 */
	protected $_defaultSingleSettings = [
	    'accept' => 'image/*',
	    'imageSize' =>  [
	        'minWidth' => 100,
	        'minHeight' => 100
	    ],
	    'elements' => [
	    	'progress' => '.uploader-progress-bar',
	    	'active' => [
	    	    'show' => '.uploader-progress',
	    	    'hide' => '.uploader-browse'
	    	]
	    ]
	];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if ($this->withPreview !== false) {
			$this->_defaultSingleSettings['elements']['preview'] = [
			    'el' => '.uploader-preview',
			    'width' => 100,
			    'height' => 100
			];
		}
		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$this->registerClientScript();
		// Очищаем значение поля с аватар-ом по умолчанию.
		$this->options['value'] = '';
		// Определяем поле виджета.
		$input = $this->hasModel() ? Html::activeHiddenInput($this->model, $this->attribute, $this->options) : Html::hiddenInput($this->name, $this->value, $this->options);
		$params = [
			'selector' => $this->getId(),
			'input' => $input,
			'fileVar' => $this->fileVar,
			'withPreview' => $this->withPreview,
			'previewUrl' => $this->previewUrl
		];
		if ($this->hasModel() && $this->withPreview && $this->previewUrl) {
			$params['previewId'] = $this->model->id;
		}
		echo $this->render('avatar', $params);
	}

	/**
	 * @inheritdoc
	 */
	public function registerClientScript()
	{
		$view = $this->getView();
		// Инициализируем плагин виджета
		$this->registerMainClientScript();
		FileAPIAvatarAsset::register($view);
		// Добавляем скрипты для удаления изображений
		$selector = ($this->selector !== null) ? '#' . $this->selector : '#' . $this->getId();
		if (($deleteUrl = $this->deleteUrl) !== null && $this->previewUrl) {
			$view->registerJs("jQuery(document).on('click', '$selector .uploader-delete', function(evt) {
				evt.preventDefault();
				var el = jQuery(this);
				jQuery.ajax({
					url : '$deleteUrl',
					type : 'DELETE',
					data : { id : el.data('id') },
					success : function (data,  textStatus, xhr) {
						jQuery('$selector .uploader-preview').html('');
						el.remove();
					}
				});
			});");
		}
	}

	/**
	 * @inheritdoc
	 */
	public function registerCallbacks()
	{
		parent::registerCallbacks();
		
		$inputId = '#' . $this->options['id'];
		$this->settings['onSelect'] = new JsExpression("function (evt, ui){
			var ufile = ui.files[0],
			    el = jQuery(this);
			if (ufile) {
				jQuery('#modal-crop').themodal({
					closeOnEsc: false,
					closeOnOverlayClick: false,
					onOpen: function (overlay) {
						jQuery(overlay).on('click', '.modal-crop-upload', function () {
							el.find('.uploader-delete').remove();
							jQuery.themodal().close();
							el.fileapi('upload');
						});
		                jQuery('.uploader-crop', overlay).cropper({
		                	file: ufile,
		                	bgColor: '#fff',
		                	maxSize: [jQuery(window).width() - 100, jQuery(window).height() - 100],
		                	minSize: [100, 100],
		                	selection: '100%',
		                	onSelect: function (coordinates) {
		                		el.fileapi('crop', ufile, coordinates);
		                	}
		                });
	                }
	            }).open();
	        }
	    }");
    	$this->_defaultSettings['onFileComplete'] = new JsExpression("function (evt, uiEvt) {
			if (uiEvt.result.error) {
				alert(uiEvt.result.error);
			} else {
				jQuery(this).find('$inputId').val(uiEvt.result.name);
			}
		}");
	}
}