#!/bin/bash
cd /
chown 0:0 var/www/html/.*
chown 0:0 var/www/html/*.*
chown 0:0 var/www/html/bin/*.*
chown www-data:www-data var/www/html/config_default.php var/www/html/newconfig
chmod 644 var/www/html/ -R
chmod 700 var/www/html/bin/*
chown dnsmasq:root /var/log/dnsmasq.log
chmod 644 /var/log/dnsmasq.log

