#!/bin/bash
#Recreate the database
#wendell.zheng <wxzheng@ustc.edu.cn>

PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin:~/bin
export PATH
php ../app/console doctrine:database:drop --force
php ../app/console doctrine:database:create
php ../app/console doctrine:schema:update --force
yes|php ../app/console doctrine:fixtures:load