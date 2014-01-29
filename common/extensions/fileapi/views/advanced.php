<?php
/**
 * Представление advanced загрузки.
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
    <?php if ($preview !== false) { ?>
        <div class="uploader-preview-cnt">
            <?php if ($delete === true) { ?>
                <?php if ($url !== null && $modelId) { ?>
                    <a href="#" class="uploader-delete uploader-delete-current" data-id="<?= $modelId ?>">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                <?php } ?>
                <a href="#" class="uploader-delete uploader-delete-temp hide">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            <?php } ?>
            <div class="uploader-preview">
                <?php if ($url !== null) { ?>
                    <img src="<?= $url ?>" alt="preview" />
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <?= $input ?>
</div>

<?php if ($crop !== false) { ?>
    <!-- Modal -->
    <div id="modal-crop">
        <div class="modal-crop-body">
            <div class="uploader-crop"></div>
            <button type="button" class="btn btn-primary modal-crop-upload"><?= FileAPIAdvanced::t('fileapi', 'Загрузить') ?></button>
        </div>
    </div>
    <!--/ Modal -->
<?php } ?>