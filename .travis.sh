#!/usr/bin/env bash

phpversion=`php -i|grep 'PHP Version'|head -n 1|grep -o -P '\d+\.\d+\.\d+.*'`

if [[ $phpversion == *5.2* ]]; then
    echo "*** PHP 5.2 can't run composer, skipping related commands"
    exit 0;
fi

composer selfupdate
composer install --prefer-dist --verbose
