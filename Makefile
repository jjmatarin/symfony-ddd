
reset-elastic:


reset-database:
	docker compose exec app-admin php bin/console doctrine:database:drop --force --if-exists
	docker compose exec app-admin php bin/console doctrine:database:create
	docker compose exec app-admin php bin/console doctrine:migrations:migrate --no-interaction
	# Fixtures

reset: reset-elastic reset-database

test: reset
	docker compose exec app-admin php bin/phpunit


