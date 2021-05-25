#!/usr/bin/env bash
# Usage: init.sh [--init][--perms][--start]

export ARGS="$1$2$3"
if [[ "$ARGS" =~ "--init" ]]; then
    echo "Updating guestbook ..."
    cd /home/guestbook
    if [[ -f ./vendor ]]; then
        php composer.phar update
    else
        php composer.phar install
    fi
    echo "Updating onlinemarket.work ..."
    cd /home/onlinemarket.work
    if [[ -f ./vendor ]]; then
        php composer.phar update
    else
        php composer.phar install
    fi
    echo "Updating onlinemarket.complete ..."
    cd /home/onlinemarket.complete
    if [[ -f ./vendor ]]; then
        php composer.phar update
    else
        php composer.phar install
    fi
    echo "Updating laminas-master ..."
    cd /home/laminas-master
    if [[ -f ./vendor ]]; then
        php composer.phar update
    else
        php composer.phar install
    fi
fi
if [[ "$ARGS" =~ "--perms" ]]; then
    echo "Setting permissions ..."
    chown apache /srv/www
    chgrp -R apache /home/*
    chmod -R 775 /home/*
fi
if [[ "$ARGS" =~ "--start" ]]; then
    echo "Initializing MySQL, PHP-FPM and Apache ... "
    /etc/init.d/mysql start
    /etc/init.d/php-fpm start
    /etc/init.d/httpd start
fi
