## Как развернуть проект

### 1. Запускаем

```
docker compose up -d
```

### 2. Открываем контейнер

```
docker exec -it task_php bash
```

### 3. Устанавливаем зависимости

```
composer install
``` 

### 4. Запускаем миграции
```
php artisan migrate --seed
```

## Нужные порты

- Серверная часть (nginx): http://localhost:8000
- База данных (pgadmin): http://localhost:8080
