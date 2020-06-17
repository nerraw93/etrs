ifndef times
override times = 1
endif

setup:
	composer install
	cp .env.example .env
	php artisan key:generate
	yarn
	make authorize
	php artisan passport:install

authorize:
	rm -rf ./storage/logs/laravel.log
	touch ./storage/logs/laravel.log
	sudo chmod -R 777 ./storage/
	sudo chmod -R 777 ./vendor/
	sudo chmod -R 777 ./bootstrap/cache/
	composer dump-autoload
	php artisan cache:clear

update:
	rm -rf ./storage/logs/laravel.log
	touch ./storage/logs/laravel.log
	sudo chmod -R 777 ./storage
	composer install
	composer dump-autoload
	php artisan cache:clear
	php artisan migrate
	yarn

refresh:
	composer install
	yarn
	php artisan cache:clear
	php artisan config:clear
	php artisan view:clear
	php artisan route:clear
	php artisan optimize:clear
	composer dump-autoload

migrateLocal:
	php artisan migrate:fresh --seed
	php artisan passport:install

testLegacyAll:
	./vendor/bin/phpunit ./tests/Api_Legacy/. --repeat ${times}

testLegacy:
	./vendor/bin/phpunit --filter ${class} tests/Api_Legacy/${path} --repeat ${times}

testApi:
	./vendor/bin/phpunit ./tests/Api/.

testSpecific:
	./vendor/bin/phpunit --filter ${class} tests/Api/${path} --repeat ${times}

testSpecificMethod:
	./vendor/bin/phpunit --filter ${method} ${class} tests/Api/${path}

setupPassport:
	php artisan passport:install
	php artisan passport:client --client

deploy:
	make down
	git reset --hard
	git pull origin master
	composer install
	yarn
	php artisan cache:clear
	php artisan config:clear
	php artisan view:clear
	php artisan route:clear
	php artisan optimize:clear
	php artisan migrate
	composer dump-autoload
	php artisan queue:restart
	yarn prod
	make up

queue:
	php artisan queue:work

restart:
	php artisan cache:clear
	php artisan config:clear
	php artisan view:clear
	php artisan route:clear
	php artisan optimize:clear
	php artisan migrate
	composer dump-autoload

migrateDeploy:
	php artisan migrate:fresh
	php artisan etrs:migrate
	php artisan app:patientGlobalIdUpdate
	php artisan passport:install

down:
	php artisan down --message="Our website is currently undergoing scheduled maintenance. We Should be back shortly. Thank you for your patience."

up:
	php artisan up
