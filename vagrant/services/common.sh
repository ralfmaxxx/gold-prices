#!/usr/bin/env bash

function update_repositories()
{
    apt-get update
}

function install_git_and_zip()
{
    apt-get install -y git zip unzip
}

function set_home_directory_for_vagrant_user()
{
    echo "cd $VAGRANT_USER_HOME_DIR" > /home/vagrant/.bashrc
}

function reload_env_variables()
{
    echo '' > /etc/nginx/custom_fastcgi_params

    for line in $(cat /vagrant/vagrant/config/environment);
    do
        echo "export $line" >> /home/vagrant/.bashrc
        echo "fastcgi_param $line;" | sed "s/='/ '/g" >> /etc/nginx/custom_fastcgi_params
    done

    service nginx restart
}

