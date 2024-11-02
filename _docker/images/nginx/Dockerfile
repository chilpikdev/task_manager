# Use the official Nginx image from Docker Hub
FROM nginx:latest

WORKDIR /var/www

# COPY /_docker/images/nginx/conf.d/default.conf /etc/nginx/conf.d/

RUN mkdir -p /var/cache/nginx/client_temp /var/run /var/log/nginx \
    && chown -R nginx:nginx /var/cache/nginx /var/run /var/log/nginx /var/www

EXPOSE 80
EXPOSE 443

RUN touch /var/run/nginx.pid \
    && chown -R nginx:nginx /var/run/nginx.pid

USER nginx

CMD ["nginx", "-g", "daemon off;"]
