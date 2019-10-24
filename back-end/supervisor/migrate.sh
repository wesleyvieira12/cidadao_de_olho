dockerize -wait tcp://redis:6379 -wait tcp://mysql:3306 tcp://php-fpm:9000 -timeout 90s
/usr/bin/supervisord -c /etc/supervisor/supervisord.conf