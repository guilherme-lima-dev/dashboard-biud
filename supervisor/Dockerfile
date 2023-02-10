FROM php:8.1.0-cli

RUN apt-get update \
    && apt-get install -y supervisor

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN mkdir -p /var/log/supervisor

RUN useradd -ms /bin/bash project
USER project

WORKDIR /app

CMD ["/usr/bin/supervisord"]