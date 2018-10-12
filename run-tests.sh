#!/bin/bash

docker-compose up -d
docker-compose run application composer install
docker-compose run application bin/phpspec run -fpretty
docker-compose run application bin/behat
