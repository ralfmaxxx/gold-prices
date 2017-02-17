#!/usr/bin/env bash

function add_php_repository()
{
    add-apt-repository -y ppa:ondrej/php
}

function install_php()
{
    PHP_MODULES=$(IFS=' ' ; echo "${PHP_MODULES[*]}")

    apt-get install -y $PHP_MODULES
}

function install_php_composer()
{
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
}
