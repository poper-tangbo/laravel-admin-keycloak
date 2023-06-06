FROM 260458320167.dkr.ecr.ap-southeast-2.amazonaws.com/heroku:22

COPY . /app

WORKDIR /app

ENV HOME=/app \
    PORT=8000 \
    PATH=/app/.heroku/php/bin:/app/.heroku/php/sbin:/app/vendor/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
