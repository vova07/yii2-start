Yii2-start
==========

Installation and getting started:
---------------------------------

If you do not have Composer, you may install it by following the instructions at getcomposer.org.

1. Run the following command: `php composer.phar create-project --prefer-dist --stability=dev vova07/yii2-start yii2-start` to install Yii2-Start.
2. Run command: `cd /my/path/to/yii2-start/` and go to main application directory.
3. Run command: `php requirements.php` and check the requirements.
4. Run command: `php init` to initialize the application with a specific environment.
5. Create a new database and adjust it configuration in `common/config/db.php` accordingly.
6. Apply migrations with console commands:
- `php yii migrate --migrationPath=@vova07/users/migrations`
- `php yii migrate --migrationPath=@vova07/blogs/migrations`
- This will create tables needed for the application to work.
7. Set document roots of your Web server: `/path/to/yii2-start/`
- Use the URL `http://yii2-start/` to access application frontend.
- Use the URL `http://yii2-start/backend/` to access application backend.

Notes:
------

By default will be created one super admin user with login `admin` and password `admin12345`, you can use this data to sing in application frontend and backend.

Themes:
-------
- Application backend it's based on "AdminLTE" template. More detail about this nice template you can find [here](http://www.bootstrapstage.com/admin-lte/).
- Application frontend it's based on "Flat Theme". More detail about this nice theme you can find [here](http://shapebootstrap.net/item/flat-theme-free-responsive-multipurpose-site-template/).