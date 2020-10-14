docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-build:
	docker-compose up --build -d

init: composer-install fixtures

composer-install:
	docker-compose exec php-cli composer install

fixtures:
	docker-compose exec php-cli php artisan migrate:refresh --seed


perm:
	sudo chgrp -R www-data storage bootstrap/cache
	sudo chmod -R ugo+rwx storage bootstrap/cache
