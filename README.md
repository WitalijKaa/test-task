# Docker + Laravel 9 + MySQL 8 + Nginx

## docker-compose up -d

---

#### dev tips

### install dependencies via Composer and Docker

- docker run --rm -v $(pwd):/app composer install
- docker run --rm -v "C:\OpenServer\domains\test-task\:/app" composer install

### migration via Docker

- docker-compose exec app php artisan migrate
