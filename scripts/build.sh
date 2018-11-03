#!/usr/bin/env bash

set -ex

echo "Checking for build lock file existence."
if [ -f /build-completed.lock ]
then
    echo "Build lock file found, skipping build."
else
    echo "No build lock file found, proceeding to build."
    COMPOSER_ALLOW_SUPERUSER=1 composer global require hirak/prestissimo
    COMPOSER_ALLOW_SUPERUSER=1 composer install
    touch /build-completed.lock
fi
