1. Переименовать .env.example в .env
2. sudo docker compose build
3. sudo docker compose up -d
4. создать /app/.env и перенести содержимое .env.dev
5. sudo docker exec -it php bash
6. запустить внутри контейнера: composer install
7. запустить внутри контейнера init.sh для добавления миграций и фикстур: init.sh и везде выбрать "y"
