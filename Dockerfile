FROM ubuntu:18.04

COPY scripts/provisioning.sh /tmp/provisioning.sh
RUN /tmp/provisioning.sh

## for development
RUN apt install -y nginx php-fpm
RUN rm /etc/nginx/sites-enabled/default
RUN rm /etc/php/7.2/fpm/pool.d/www.conf

## user
RUN useradd -m -s /bin/bash -u 1000 -g users ubuntu

RUN apt install sudo
RUN echo "ubuntu ALL=(ALL:ALL) NOPASSWD:ALL" >> /etc/sudoers
RUN chown ubuntu:users /srv
