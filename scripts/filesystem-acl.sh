#!/usr/bin/env bash

set -ex

echo "Remove cache and logs directories."
sudo rm -rf ./var/cache ./var/logs ./var/sessions

echo "Create cache and logs directories."
mkdir ./var/cache
mkdir ./var/logs
mkdir ./var/sessions

echo "Apply filesystem ACL on cache and logs directories."
sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX ./var/cache ./var/logs ./var/sessions
sudo setfacl -dR -m u:www-data:rwX -m u:`whoami`:rwX ./var/cache ./var/logs ./var/sessions

if [ -d ./web/uploads ]; then
    echo "Web upload directory exists."
else
    echo "Create web upload directory."
    mkdir ./web/uploads
fi

echo "Apply filesystem ACL on web upload directory."
sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX ./web/uploads
sudo setfacl -dR -m u:www-data:rwX -m u:`whoami`:rwX ./web/uploads
