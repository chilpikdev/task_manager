# Используем официальный образ Nginx
FROM nginx:latest
# Устанавливаем рабочую директорию
WORKDIR /etc/nginx
# Копируем конфигурацию Nginx
COPY /_docker/images/nginx/conf.d/prod.conf /etc/nginx/conf.d/
# Копируем статические файлы приложения (будут заменены при сборке фронтенда)
COPY ./nginx.conf /etc/nginx/nginx.conf
# Открываем порты
EXPOSE 80 EXPOSE 443
# Запускаем Nginx
CMD ["nginx", "-g", "daemon off;"]
