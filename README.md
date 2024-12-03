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
6. **Примените migrations:** `docker exec -it app php artisan migrate`.
7. **Запустите seeders:** `docker exec -it app php artisan db:seed`.
8. **Откройте приложение:** доступно по адресу [http://localhost:8888](http://localhost:8888).
9. **Сгенерируйте документацию:** `docker exec -it app php artisan l5-swagger:generate`.
10. **Запустите тесты:** выполните `docker exec -it app php artisan test`.
11. Через postman можно обратиться к [http://localhost:8888/api/tasks](http://localhost:8888/api/tasks)
    с Bearer Token - token для получения доступа к таскам. Сам токен лежит в .env  - API_BEARER_TOKEN
12. Swagger документация после ее генерации из пункта 9 будет доступна по ссылке [http://localhost:8888/admin/swagger](http://localhost:8888/admin/swagger)

Теперь проект готов к использованию!


----------

# ENG Description Test task

Implemented: Docker for running the application, migrations for the task table, task model, factory for generating tasks, API
Resource controller, methods for working with tasks, repository for interacting with ORM, Swagger for documenting
API, Feature and Unit tests.

### Instructions

1. **Clone the repository:** download the project and go to the `test-task` folder.
2. **Configure the environment:** create a `.env` file from `.env.example`, you can leave the default settings.
3. **Run the containers:** run `docker-compose up -d --build`.
4. **Install dependencies:** `docker exec -it app composer install` inside the application container.
5. **Generate the key:** `docker exec -it app php artisan key:generate`.
6. **Apply migrations:** `docker exec -it app php artisan migrate`.
7. **Run seeders:** `docker exec -it app php artisan db:seed`.
8. **Open the application:** available at [http://localhost:8888](http://localhost:8888).
9. **Generate documentation:** `docker exec -it app php artisan l5-swagger:generate`.
10. **Run tests:** run `docker exec -it app php artisan test`.
11. Via postman you can access [http://localhost:8888/api/tasks](http://localhost:8888/api/tasks)
    with a Bearer Token - token to access tasks. The token itself is in .env - API_BEARER_TOKEN
12. Swagger documentation after its generation from point 9 will be available at the link [http://localhost:8888/admin/swagger](http://localhost:8888/admin/swagger)

Now the project is ready for use!

---------

# ENG
