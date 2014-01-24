<?php
namespace common\extensions\fileapi;

use Yii;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\web\JsExpression;
use common\extensions\fileapi\assets\FileAPIAdvancedAsset;
use common\extensions\fileapi\assets\FileAPIAdvancedCropAsset;

/**
 * FileAPIAdvanced Class
 * Виджет асинхроной загрузки файлов.
 * Работает на основе плагина {@link https://github.com/RubaXa/jquery.fileapi/ FileAPI}.
 * Пример использования:
 * ```
 * ...
 * echo FileAPIAdvanced::widget([
 *     'name' => 'fileapi',
 *     'settings' => [
 *         'crop' => true,
 *         'preview' => true
 *     ]
 * ]);
 * ...
 * ```
 * или
 * ```
 * ...
 * echo $form->field($model, 'file')->widget(FileAPIAdvanced::className(), [
 *     'settings' => [
 *         'crop' => true,
 *         'preview' => true
 *     ]
 * ]);
 * ...
 * ```
 */
class FileAPIAdvanced extends FileAPI
{
	/**
	 * @var string URL для удаления текущего файла.
	 */
	public $deleteUrl;

	/**
	 * @var string URL для удаления загруженного файла.
	 * Для удаления не загруженного файла из списка загрузки плагина, нужно использовать функционал {@link https://github.com/RubaXa/jquery.fileapi/ FileAPI}.
	 */
	public $deleteTempUrl;

	/**
	 * @var string ID текущей моедли, или в случае её отсутсвия,
	 * значение которое будет передано через AJAX запрос в метод удаления текущего файла.
	 */
	public $modelId;

	/**
	 * @var boolean Определяем если нужно выводить загружаемый файл в отдельное окно, для его нарезки.
	 */
	public $crop = false;

	/**
	 * @var integer Ширина исходной картинки после resize-а.
	 * Параметр валиден только в случае использования $crop.
	 */
	public $cropResizeWidth;

	/**
	 * @var integer Высота исходной картинки после resize-а.
	 * Параметр валиден только в случае использования $crop.
	 */
	public $cropResizeHeight;

	/**
	 * @var boolean Определяем если нужно показывать преьвю загружаемого файла.
	 */
	public $preview = true;

	/**
	 * @var string URL адрес папки где хранятся уже загруженные файлы.
	 */
	public $url;

	/**
	 * @var array Настройки виджета по умолчанию
	 */
	protected $_defaultSingleSettings = [
	    'accept' => 'image/*',
	    'autoUpload' => true,
	    'imageSize' =>  [
	        'minWidth' => 100,
	        'minHeight' => 100
	    ],
	    'elements' => [
	    	'progress' => '.uploader-progress-bar',
	    	'active' => [
	    	    'show' => '.uploader-progress',
	    	    'hide' => '.uploader-browse'
	    	],
	    	'preview' => [
	    	    'el' => '.uploader-preview',
			    'width' => 100,
			    'height' => 100
	    	]
	    ]
	];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		// Определяем контейнер превью
		if ($this->preview !== false) {
			$this->_defaultSingleSettings['elements']['preview'] = [
			    'el' => '.uploader-preview',
			    'width' => 100,
			    'height' => 100
			];
		}
		// Определяем URL
		if ($this->url !== null) {
			$fileName = $this->hasModel() ? $this->model->{$this->attribute} : $this->value;
			$this->url = $fileName ? rtrim($this->url, '/') . '/' . $fileName : null;
		}
		// Определяем ИД модели
		if ($this->modelId === null && $this->hasModel()) {
			$this->modelId = 'id';
		}
		// Отменяем авто-загрузку в случае использования кропа
		if ($this->crop !== false) {
			$this->settings['autoUpload'] = false;
		}
		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$this->registerClientScript();
		// Очищаем значение поля по умолчанию.
		$this->options['value'] = '';
		// Определяем поле виджета.
		$input = $this->hasModel() ? Html::activeHiddenInput($this->model, $this->attribute, $this->options) : Html::hiddenInput($this->name, $this->value, $this->options);
		// Определяем ИД модели
		$modelId = $this->hasModel() ? $this->model->{$this->modelId} : $this->modelId;
		// Определяем если нужно выводить ссылки для удаления файлов
		$delete = $this->deleteUrl && $this->deleteTempUrl;
		// Рендерим представление
		echo $this->render('advanced', [
			'selector' => $this->getId(),
			'input' => $input,
			'fileVar' => $this->fileVar,
			'preview' => $this->preview,
			'delete' => $delete,
			'crop' => $this->crop,
			'url' => $this->url,
			'modelId' => $modelId
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function registerClientScript()
	{
		$view = $this->getView();
		// Инициализируем плагин виджета
		$this->registerMainClientScript();
		if ($this->crop !== false) {
			FileAPIAdvancedCropAsset::register($view);
		} else {
			FileAPIAdvancedAsset::register($view);
		}
		// Добавляем скрипты для удаления файлов.
		$selector = ($this->selector !== null) ? '#' . $this->selector : '#' . $this->getId();
		$inputId = '#' . $this->options['id'];
		if ($this->deleteUrl !== null && $this->url) {
			$deleteUrl = $this->deleteUrl;
			$view->registerJs("jQuery(document).on('click', '$selector .uploader-delete-current', function(evt) {
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
		if ($this->deleteTempUrl !== null) {
			$deleteTempUrl = $this->deleteTempUrl;
			$view->registerJs("jQuery(document).on('click', '$selector .uploader-delete-temp', function(evt) {
				evt.preventDefault();
				var el = jQuery(this),
				    uid = el.data('id'),
				    widget = jQuery('$selector');
				if (!el.hasClass('disabled')) {
					jQuery.ajax({
						url : '$deleteTempUrl',
						type : 'DELETE',
						data : { file : el.data('name') },
						success : function (data,  textStatus, xhr) {
							widget.fileapi('remove', uid);
							widget.find('.uploader-preview').html('');
							widget.find('$inputId').val('');
							el.addClass('hide');

						}
					});
				}
			});");
		}
	}

	/**
	 * @inheritdoc
	 */
	public function registerCallbacks()
	{
		$inputId = '#' . $this->options['id'];
		if ($this->crop !== false) {
			// Определяем если картинку нужно уменьшить до указаных размеров после выделения с Jcrop.
			if ($this->cropResizeWidth !== null && $this->cropResizeHeight !== null) {
				$cropResizeWidth = $this->cropResizeWidth;
				$cropResizeHeight = $this->cropResizeHeight;
				$cropResizeJs = "el.fileapi('resize', ufile, $cropResizeWidth, $cropResizeHeight);";
			} else {
				$cropResizeJs = '';
			}
			// Регистрируем обработчик события для вывода окна выделения изображения.
			$this->_defaultSettings['onSelect'] = new JsExpression("function (evt, ui){
				var ufile = ui.files[0],
				    el = jQuery(this);
				if (ufile) {
					jQuery('#modal-crop').themodal({
						closeOnEsc: false,
						closeOnOverlayClick: false,
						onOpen: function (overlay) {
							jQuery(overlay).on('click', '.modal-crop-upload', function () {
								el.find('.uploader-delete-current').remove();
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
			                		$cropResizeJs
			                	}
			                });
		                }
		            }).open();
		        }
		    }");
		}
		// Определяем если нужно выводить ссылку для удаления загружаемого файла.
		if ($this->deleteTempUrl !== null) {
			$this->_defaultSettings['onFileComplete'] = new JsExpression("function (evt, uiEvt) {
				if (uiEvt.result.error) {
					alert(uiEvt.result.error);
				} else {
					var uid = FileAPI.uid(uiEvt.file);
					jQuery(this).find('.uploader-delete-current').remove();
					jQuery(this).find('.uploader-delete-temp').removeClass('hide').attr({ 'data-name' : uiEvt.result.name, 'data-id' : uid });
					jQuery(this).find('$inputId').val(uiEvt.result.name);
				}
			}");
		} else {
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