#!/usr/bin/env bash

. /vagrant/vagrant/services/common.sh
. /vagrant/vagrant/services/nginx.sh
. /vagrant/vagrant/services/php.sh
. /vagrant/vagrant/services/mysql.sh

VAGRANT_USER_HOME_DIR='/vagrant'

PHP_MODULES=(
    'php7.1-dev'
    'php7.1-mysql'
    'php7.1-fpm'
    'php7.1-curl'
    'php7.1-intl'
    'php7.1-xml'
    'php7.1-mbstring'
    'php7.1-bcmath'
)

add_php_repository &&
update_repositories &&
install_git_and_zip &&
set_home_directory_for_vagrant_user &&

install_php &&
install_php_composer &&

install_nginx &&
load_nginx_configuration &&

install_mysql &&
allow_external_mysql_connection &&
allow_to_log_in_with_root_account &&

reload_env_variables
