#!/bin/bash

apt install php-mysql;
mkdir /var/www/html/BookstoreSystem;
cp -r ./css ./html ./image ./v1 ./js /var/www/html/BookstoreSystem;
cp ./BookstoreSystem.conf /etc/nginx/sites-enabled;
mysql < ./initialize.sql;

