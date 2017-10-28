FROM docker.io/codereviewvideos/php-7:latest


ARG WORK_DIR
WORKDIR $WORK_DIR


COPY composer.lock $WORK_DIR
COPY composer.json $WORK_DIR

COPY app $WORK_DIR/app
COPY bin $WORK_DIR/bin
COPY src $WORK_DIR/src
COPY web $WORK_DIR/web

COPY ./app/config/parameters.yml.dist $WORK_DIR/app/config/parameters.yml


ENV COMPOSER_ALLOW_SUPERUSER 1

RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-scripts


RUN chown -R www-data:www-data $WORK_DIR


USER www-data
