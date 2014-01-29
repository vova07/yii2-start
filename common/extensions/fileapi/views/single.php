<?php
/**
 * Представление одиночной загрузки.
 * @var yii\base\View $this Представление
 */

use common\extensions\fileapi\FileAPIAdvanced;
?>
<div id="<?= $selector; ?>" class="uploader">
    <div class="btn btn-default js-fileapi-wrapper">
        <div class="uploader-browse">
            <?= FileAPIAdvanced::t('fileapi', 'Выбрать') ?>
            <input type="file" name="<?= $fileVar ?>">
        </div>
        <div class="uploader-progress">
            <div class="progress progress-striped">
                <div class="uploader-progress-bar progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    <?= $input ?>
</div>