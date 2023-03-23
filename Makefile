dev: cp-env build install-deps up migrate

cp-env:
	cp apps/api/.env.dist apps/api/.env
build:
	docker-compose -f docker-compose.dev.yaml build --no-cache

up:
	docker-compose -f docker-compose.dev.yaml up -d

install-deps:
	docker-compose -f docker-compose.dev.yaml run --rm api composer install
	docker-compose -f docker-compose.dev.yaml run --rm client yarn install

migrate:
	docker-compose -f docker-compose.dev.yaml run --rm api bin/console doctrine:database:drop --if-exists --force
	docker-compose -f docker-compose.dev.yaml run --rm api bin/console doctrine:database:create --if-not-exists
	docker-compose -f docker-compose.dev.yaml run --rm api bin/console doctrine:migration:migrate
