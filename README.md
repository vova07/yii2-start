Yii2-start
==========

DEMO:
-----

**Frontend:** [http://yii2-start.find-freelancer.pro](http://yii2-start.find-freelancer.pro)  
**Backend:** [http://yii2-start.find-freelancer.pro/backend/](http://yii2-start.find-freelancer.pro/backend/)  

**Authentication:**  
_Login:_ `demo`  
_Password:_ `demo12345`  

Installation and getting started:
---------------------------------

**If you do not have Composer, you may install it by following the instructions at getcomposer.org.**

**If you do not have Composer-Asset-Plugin installed, you may install it by running command:** `php composer.phar global require "fxp/composer-asset-plugin:1.0.0-beta3"`

1. Run the following commands to install Yii2-Start: `php composer.phar create-project --prefer-dist --stability=dev vova07/yii2-start yii2-start`  
   **During the installation process can be required `password` and\or `username` from your Github account. This is because you make too much request to Github service. Just remember that this can be.**
2. Run command: `cd /my/path/to/yii2-start/` and go to main application directory.
3. Run command: `php requirements.php` and check the requirements.
4. Run command: `php init` to initialize the application with a specific environment.
5. Create a new database and adjust it configuration in `common/config/db.php` accordingly.
6. Apply migrations with console commands:
   - `php yii migrate --migrationPath=@vova07/users/migrations`
   - `php yii migrate --migrationPath=@vova07/blogs/migrations`
   - `php yii migrate --migrationPath=@vova07/comments/migrations`
   - This will create tables needed for the application to work.
   - You also can use database dump `db.sql` from `my/path/to/yii2-start/common/data`, but however I recommend to use migrations.
7. Run modules RBAC commands:
   - `php yii rbac/rbac/init`
   - `php yii users/rbac/add`
   - `php yii blogs/rbac/add`
   - `php yii comments/rbac/add`
8. Set document roots of your Web server:

  **For Apache:**
    
  ```
  <VirtualHost *:80>
      ServerName www.yii2-start.domain # You need to change it to your own domain  
	  ServerAlias yii2-start.domain # You need to change it to your own domain  
	  DocumentRoot /my/path/to/yii2-start # You need to change it to your own path  
	  <Directory /my/path/to/yii2-start> # You need to change it to your own path  
		  AllowOverride All  
	  </Directory>  
  </VirtualHost>
  ```  
  - Use the URL `http://yii2-start.domain` to access application frontend.
  - Use the URL `http://yii2-start.domain/backend/` to access application backend.
  
  **For Nginx:**
  
    ___Frontend___
    
    ``` 
    server {
        charset utf-8;
        client_max_body_size 128M;

        listen 80; ## listen for ipv4
        # listen [::]:80 ipv6only=on; ## listen for ipv6

        set $yii2StartRoot '/my/path/to/yii2-start'; ## You need to change it to your own path

        server_name yii2-start.domain; ## You need to change it to your own domain
        root $yii2StartRoot/frontend/web;
        index index.php;

        #access_log  $yii2StartRoot/log/frontend/access.log;
        #error_log   $yii2StartRoot/log/frontend/error.log;

        location / {
            # Redirect everything that isn't a real file to index.php
            try_files $uri $uri/ /index.php?$args;
        }

        location /statics {
            alias $yii2StartRoot/statics/web/;
        }

        # uncomment to avoid processing of calls to non-existing static files by Yii
        #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        #    try_files $uri =404;
        #}
        #error_page 404 /404.html;

        location ~ \.php$ {
            #include fastcgi_params;
            include fastcgi.conf;
            fastcgi_pass   127.0.0.1:9000;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }

        location ~ /\.(ht|svn|git) {
            deny all;
        }
    }
    ```
    
    __Backend__
    
    ```
    server {
        charset utf-8;
        client_max_body_size 128M;

        listen 80; ## listen for ipv4
        # listen [::]:80 ipv6only=on; ## listen for ipv6

        set $yii2StartRoot '/my/path/to/yii2-start'; ## You need to change it to your own path
        
        server_name backend.yii2-start.domain; ## You need to change it to your own domain
        root $yii2StartRoot/backend/web;
        index index.php;

        #access_log  $yii2StartRoot/log/backend/access.log;
        #error_log   $yii2StartRoot/log/backend/error.log;

        location / {
            # Redirect everything that isn't a real file to index.php
            try_files $uri $uri/ /index.php?$args;
        }

        location /statics {
            alias $yii2StartRoot/statics/web/;
        }

        # uncomment to avoid processing of calls to non-existing static files by Yii
        #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        #    try_files $uri =404;
        #}
        #error_page 404 /404.html;

        location ~ \.php$ {
            #include fastcgi_params;
            include fastcgi.conf;
            fastcgi_pass   127.0.0.1:9000;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }

        location ~ /\.(ht|svn|git) {
            deny all;
        }
    }
    ```
    
    **Remove `'baseUrl' => '/backend'` from `/my/path/to/yii2-start/backend/config/main.php`.**
    
    - Use the URL `http://yii2-start.domain` to access application frontend.
    - Use the URL `http://backend.yii2-start.domain` to access application backend.

Notes:
------

By default will be created one super admin user with login `admin` and password `admin12345`, you can use this data to sing in application frontend and backend.

Themes:
-------
- Application backend it's based on "AdminLTE" template. More detail about this nice template you can find [here](http://www.bootstrapstage.com/admin-lte/).
- Application frontend it's based on "Flat Theme". More detail about this nice theme you can find [here](http://shapebootstrap.net/item/flat-theme-free-responsive-multipurpose-site-template/).