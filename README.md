# Тестовое задание

Реализовано: Docker для запуска приложения, миграции для таблицы заданий, модель заданий, фабрика для генерации заданий, API
Resource контроллер, методы для работы с заданиями, репозиторий для взаимодействия с ORM, Swagger для документирования
API, Feature и Unit тесты.

### Инструкция

1. **Клонируйте репозиторий:** скачайте проект и перейдите в папку `test-task`.
2. **Настройте окружение:** создайте файл `.env` из `.env.example`, настройки можно оставить по умолчанию.
3. **Запустите контейнеры:** выполните `docker-compose up -d --build`.
4. **Установите зависимости:** `docker exec -it app composer install` внутри контейнера приложения.
5. **Сгенерируйте ключ:** `docker exec -it app php artisan key:generate`.
6. **Примените миграции:** `docker exec -it app php artisan migrate`.
7. **Запустите сидеры:** `docker exec -it app php artisan db:seed`.
8. **Откройте приложение:** доступно по адресу [http://localhost:8888](http://localhost:8888).
9. **Сгенерируйте документацию:** `docker exec -it app php artisan l5-swagger:generate`.
10. **Запустите тесты:** выполните `docker exec -it app php artisan test`.
11. Через postman можно обратиться к [http://localhost:8888/api/tasks](http://localhost:8888/api/tasks)
    с Bearer Token - token для получения доступа к таскам.

Теперь проект готов к использованию!
