#!/usr/bin/env bash

function install_nginx()
{
    apt-get install -y nginx
}

function load_nginx_configuration()
{
    ln -sf /vagrant/vagrant/config/nginx.conf /etc/nginx/sites-enabled/default
    service nginx restart
}
