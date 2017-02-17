#!/usr/bin/env bash

function install_mysql()
{
    echo mysql-server mysql-server/root_password password passwd | debconf-set-selections
    echo mysql-server mysql-server/root_password_again password passwd | debconf-set-selections

    apt-get install -y mysql-server
}

function allow_external_mysql_connection()
{
    sed -i.bu 's/bind-address/#bind-address/' /etc/mysql/my.cnf

    service mysql restart
}

function allow_to_log_in_with_root_account()
{
    mysql -ppasswd -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '$MYSQL_PASSWORD';"

    service mysql restart
}
