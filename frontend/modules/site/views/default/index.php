<?php

/**
 * Frontend main page view.
 *
 * @var yii\web\View $this View
 */

$this->title = Yii::$app->name;
$this->params['noTitle'] = true; ?>

<section id="main-slider" class="no-margin center">
    <div class="well">
        <p><img src="<?= $this->assetManager->publish('@frontend/themes/site/images/slider/bg2.png')[1] ?>" alt="Yii 2" /></p>
        <p>A fast and easy way to start an Yii 2 project, with flexible functionality and structure.</p>
        <a href="https://github.com/vova07/yii2-start" class="btn btn-primary btn-lg" target="_blank">Github</a>
    </div>
</section>

<section id="services" class="emerald">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-user icon-md"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="media-heading"><?= Yii::t('site', 'User management') ?></h3>
                        <p>Backend and Frontend user management. Full CRUD functionality, filtering, searching, and user's avatar uploading.</p>
                    </div>
                </div>
            </div><!--/.col-md-4-->
            <div class="col-md-4 col-sm-6">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-book icon-md"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="media-heading"><?= Yii::t('themes', 'Post management') ?></h3>
                        <p>Backend and Frontend post management. Full CRUD functionality, filtering, searching, and files uploading.</p>
                    </div>
                </div>
            </div><!--/.col-md-4-->
            <div class="col-md-4 col-sm-6">
                <div class="media">
                    <div class="pull-left">
                        <i class="icon-leaf icon-md"></i>
                    </div>
                    <div class="media-body">
                        <h3 class="media-heading">Free nice themes</h3>
                        <p>On backend it's used functional "AdminLTE" template, and on frontend the beautiful "Flat Theme". Both are free to use.</p>
                    </div>
                </div>
            </div><!--/.col-md-4-->
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="center">
                    <h2>Installation and getting started:</h2>
                </div>
                <div class="alert alert-warning center">
                    <p>If you do not have Composer, you may install it by following the instructions at <a href="getcomposer.org" target="_blank">getcomposer.org</a>.</p>
                </div>
                <ol>
                    <li>
                        <p>Run the following command: <code>php composer.phar create-project --prefer-dist --stability=dev vova07/yii2-start yii2-start</code> to install Yii2-Start.</p>
                    </li>
                    <li>
                        <p>Run command: <code>cd /my/path/to/yii2-start/</code> and go to main application directory.</p>
                    </li>
                    <li>
                        <p>Run command: <code>php requirements.php</code> and check the requirements.</p>
                    </li>
                    <li>
                        <p>Run command: <code>php init</code> to initialize the application with a specific environment.</p>
                    </li>
                    <li>
                        <p>Create a new database and adjust it configuration in <code>common/config/db.php</code> accordingly.</p>
                    </li>
                    <li>
                        <p>Apply migrations with console commands:</p>
                        <p><code>php yii migrate --migrationPath=@vova07/users/migrations</code></p>
                        <p><code>php yii migrate --migrationPath=@vova07/blogs/migrations</code></p>
                        <p>This will create tables needed for the application to work.</p>
                    </li>
                    <li>
                        <p>Set document roots of your Web server: <code>/path/to/yii2-start/</code></p>
                        <p>Use the URL <code>http://yii2-start/</code> to access application frontend.</p>
                        <p>Use the URL <code>http://yii2-start/backend/</code> to access application backend.</p>
                    </li>
                </ol>
                <div class="center">
                    <h3>Notes:</h3>
                </div>
                <p>By default will be created one super admin user with login <code>admin</code> and password <code>admin12345</code>, you can use this data to sing in application frontend and backend.</p>
                <div class="center">
                    <h3>Themes:</h3>
                </div>
                <p>Application backend it's based on "AdminLTE" template. More detail about this nice template you can find <a href="http://www.bootstrapstage.com/admin-lte/" target="_blank">here</a>.</p>
                    <p>Application frontend it's based on "Flat Theme". More detail about this nice theme you can find <a href="http://shapebootstrap.net/item/flat-theme-free-responsive-multipurpose-site-template/" target="_blank">here</a>.</p>
            </div>
        </div><!--/.row-->
    </div>
</section>