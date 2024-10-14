#!/bin/bash

apt install php-mysql, php-curl;
mkdir /var/www/html/BookstoreSystem;
cp -r ./css ./html ./image ./v1 ./js ./image ./old ./upload /var/www/html/BookstoreSystem;
chown www-data:www-data /var/www/html/BookstoreSystem/upload;
cp ./BookstoreSystem.conf /etc/nginx/sites-enabled;
mysql < ./initialize.sql;
redis-cli sadd set_one "ttt";

