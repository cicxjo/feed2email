# SPDX-FileCopyrightText: 2024 Cyril AUGIER <cicxjo@posteo.net>, et al.
#
# SPDX-License-Identifier: GPL-3.0-or-later

FROM docker.io/debian:latest

COPY ../composer.json /

ENV COMPOSER /composer.json
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_VENDOR_DIR /vendor/
# ENV PATH /vendor/bin:$PATH

ENV DEBIAN_FRONTEND noninteractive

RUN apt -y update
RUN apt -y install php-cli
RUN apt -y install php-simplexml php-tokenizer php-xmlwriter php-curl
RUN apt -y install composer
RUN apt -y purge --autoremove
RUN apt -y clean autoclean
RUN composer install --prefer-dist --no-progress
RUN composer clear-cache

ENTRYPOINT ["bash", "-c"]
