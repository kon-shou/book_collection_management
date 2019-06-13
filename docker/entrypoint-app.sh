#!/bin/bash

mkdir -p ~/.config/psysh
touch ~/.config/psysh/psysh_history

sudo service php7.2-fpm start
sudo service nginx start

tail -f /dev/null
