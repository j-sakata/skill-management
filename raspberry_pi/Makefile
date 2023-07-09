up:
	docker compose up -d
build:
	docker compose build --no-cache --force-rm
init:
	docker compose up -d --build
	mkdir ../backend/init
	cp -r ../exclude/init ../backend/
	docker compose exec app cp -r init/app init/framework storage
	rm -rf ../backend/init
	@make authority
	docker compose exec app composer install
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan storage:link
	docker compose exec web rm -rf webpack.mix.js
	docker compose exec web ln -s resources/webpack.mix.js webpack.mix.js
	@make yarn
	@make yarn-dev
	@make migrate
	@make dml
remake:
	@make destroy
	@make init
stop:
	docker compose stop
down:
	docker compose down --remove-orphans
restart:
	@make down
	@make up
destroy:
	docker compose down --rmi all --volumes --remove-orphans
destroy-volumes:
	docker compose down --volumes --remove-orphans
web:
	docker compose exec web ash
app:
	docker compose exec app bash
migrate:
	docker compose exec app php artisan migrate
fresh:
	docker compose exec app php artisan migrate:fresh
seed:
	docker compose exec app php artisan db:seed
	@make dml
optimize:
	docker-compose exec app php artisan optimize
optimize-clear:
	docker-compose exec app php artisan optimize:clear
authority:
	docker compose exec app chmod -vR 777 storage storage/logs/laravel.log bootstrap/cache
cache:
	docker compose exec app composer dump-autoload -o
	@make optimize
	docker compose exec app php artisan event:cache
	docker compose exec app php artisan view:cache
cache-clear:
	docker compose exec app composer clear-cache
	@make optimize-clear
	docker compose exec app php artisan event:clear
npm:
	docker-compose exec web npm install
npm-dev:
	docker compose exec web npm run dev
yarn:
	docker compose exec web yarn
yarn-dev:
	docker compose exec web yarn dev
db:
	docker compose exec db bash
sql:
	docker compose exec db bash -c 'mysql -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'
dml:
	docker compose exec db bash -c 'mysql -u $$MYSQL_ROOT_USER -p$$MYSQL_PASSWORD --local_infile=1 $$MYSQL_DATABASE -e"source /tmp/dml/import_inital_data.sql;"'
