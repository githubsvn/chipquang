Deployment for TYHV with Symfony2

1) Get Composer with command :
-----------------------------

    php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"

2) Get Symfony2 standard components :
------------------------------------

    php composer.phar install

3) Configuration for DB
-----------------------
	- Edit app/config/parameters.yml to config database and config host

4) Generate DB and Entity
-------------------------

    - Run in command line to generate database:
        php app/console doctrine:schema:update --force

    - Setup default User, Language run in command line:
        php app/console doctrine:fixtures:load

5) Clear all cache before run application
-----------------------------------------
    php app/console assets:install web
    php app/console cache:clear

6) Modify stfalcon_tinymce base_url in config.yaml and host in parameters.yml

7) How to use LiipImagineBUndle
    - In the config.yml file
        liip_imagine:
            web_root: %kernel.root_dir%/../web/uploads/                     ==> path to your image directory
            filter_sets:
              thumbs:
                quality: 75
                filters:
                  thumbnail: { size: [100, 100], mode: outbound }
Have fun !
