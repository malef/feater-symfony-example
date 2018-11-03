#!/usr/bin/env bash

set -ex

echo "Waiting for build to complete."
while [ ! -f /build-completed.lock ]
do
  sleep 2
done

echo "Starting web server."
bin/console server:run *:8000 --env=$SYMFONY_ENV
