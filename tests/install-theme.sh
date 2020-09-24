#!/usr/bin/env bash

DIR=$(cd $(dirname $0)/.. && pwd)
rm -rf ${DIR}/.themes
wget -P ${DIR}/.themes https://github.com/inc2734/snow-monkey/archive/master.zip
unzip -o ${DIR}/.themes/master.zip -d ${DIR}/.themes
mv ${DIR}/.themes/snow-monkey-master ${DIR}/.themes/snow-monkey
cd ${DIR}/.themes/snow-monkey && composer install --no-dev --no-interaction
