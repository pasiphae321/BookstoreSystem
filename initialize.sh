#!/bin/bash

apt update;
apt install nginx php php-fpm mysql-server redis curl php-mysql php-redis php-curl;
mkdir /var/www/html/BookstoreSystem;
cp -r ./css ./html ./image ./v1 ./js ./old ./upload /var/www/html/BookstoreSystem;
chown www-data:www-data /var/www/html/BookstoreSystem/upload;
rm /etc/nginx/sites-enabled/default && cp ./BookstoreSystemForNginx.conf /etc/nginx/sites-enabled;
mysql < ./initialize.sql;
redis-cli sadd set_one "initialize";
systemctl restart nginx;
systemctl restart php7.4-fpm;
systemctl restart mysql;
systemctl restart redis;

