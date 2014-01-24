<?php
/**
 * Представления загрузки аватар-а
 * @var yii\base\View $this
 */
?>
<div id="<?= $selector; ?>" class="uploader">
    <div class="btn btn-default js-fileapi-wrapper">
        <div class="uploader-browse">
            <?= Yii::t('app', 'Выбрать') ?>
            <input type="file" name="<?= $fileVar ?>">
        </div>
        <div class="uploader-progress">
            <div class="progress progress-striped">
                <div class="uploader-progress-bar progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    <?php if ($withPreview !== false) { ?>
        <div class="uploader-preview-cnt">
            <?php if ($previewUrl && isset($previewId)) { ?>
                <a href="#" class="uploader-delete" data-id="<?= $previewId ?>">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            <?php } ?>
            <div class="uploader-preview">
                <?php if ($previewUrl) { ?>
                    <img src="<?= $previewUrl ?>" alt="Avatar" />
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <?= $input ?>
</div>

<!-- Modal -->
<div id="modal-crop">
    <div class="modal-crop-body">
        <div class="uploader-crop"></div>
        <button type="button" class="btn btn-primary modal-crop-upload"><?= Yii::t('app', 'Загрузить') ?></button>
    </div>
</div>
<!--/ Modal -->