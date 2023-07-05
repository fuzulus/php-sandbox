FROM nginx:alpine

RUN addgroup -g 1000 -S app && adduser -S app -D -u 1000 -G app

COPY docker/services/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/services/nginx/nginx.conf /etc/nginx/nginx.conf

COPY ./public /opt/app/public
RUN chown -R app:app /opt/app

USER app
