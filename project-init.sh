#!/usr/bin/env bash
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
sudo apt-get -y install mysql-server

mysql -uroot -proot -e "CREATE DATABASE excel /*\!40100 DEFAULT CHARACTER SET utf8 */;"


cd /var/www/
composer install
./vendor/doctrine/doctrine-module/bin/doctrine-module orm:schema-tool:create
./vendor/doctrine/doctrine-module/bin/doctrine-module migrations:migrate
./vendor/doctrine/doctrine-module/bin/doctrine-module orm:info