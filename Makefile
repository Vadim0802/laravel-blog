setup: composer frontend key migrate seed start-app

start-app:
	php artisan serve --host 0.0.0.0 --port 8000

key:
	php artisan key:generate

migrate:
	php artisan migrate:fresh

seed:
	php artisan db:seed

composer:
	composer install

frontend:
	npm install && npm run dev