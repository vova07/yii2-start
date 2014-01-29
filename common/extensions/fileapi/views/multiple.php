<?php
/**
 * Представление мульти-загрузки.
 * @var yii\base\View $this Представление
 */

use common\extensions\fileapi\FileAPIAdvanced;
?>
<div id="<?= $selector; ?>" class="uploader">
    <div class="uploader-controls">
	    <div class="uploader-browse btn btn-default js-fileapi-wrapper">
	        <span><?= FileAPIAdvanced::t('fileapi', 'Добавить файл'); ?></span>
	        <input type="file" name="<?= $fileVar ?>" />
	    </div>
    </div>
    <div class="uploader-dnd"><?= FileAPIAdvanced::t('fileapi', 'Drag and Drop') ?></div>
    <div class="uploader-dnd-not-supported"><?= FileAPIAdvanced::t('fileapi', 'Браузер не поддерживает "Drag and Drop"'); ?></div>
    <div class="uploader-files row">
    	<div class="uploader-file-tpl col-sm-2">
            <div class="uploader-file">
        	    <div class="uploader-file-progress">
        	        <div class="progress progress-striped">
        	            <div class="uploader-file-progress-bar progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        	        </div>
        	    </div>
        	    <div class="uploader-file-preview"></div>
                <div class="col-sm-10 uploader-file-fields"></div>
            </div>
    	</div>
    </div>
</div>