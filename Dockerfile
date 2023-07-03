FROM 701150702050.dkr.ecr.ap-northeast-1.amazonaws.com/heroku:22

COPY . /app

WORKDIR /app

RUN chmod -R 777 /app/storage

ENV HOME=/app \
    PORT=8000 \
    PATH=/app/.heroku/php/bin:/app/.heroku/php/sbin:/app/vendor/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
