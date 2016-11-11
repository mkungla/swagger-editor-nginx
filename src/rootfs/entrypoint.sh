#!/bin/bash

set -e
trap "echo TRAPed signal" HUP INT QUIT TERM

# start nginx in background here
echo "starting php-fpm"
su-exec root php-fpm

echo "starting nginx"
su-exec root nginx -g 'daemon off;'

exec "$@"