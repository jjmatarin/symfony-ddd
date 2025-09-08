
reset-elastic:
	docker compose exec app-admin curl -s -X DELETE http://elasticsearch:9200/clients

reset-database:
	docker compose exec app-admin php bin/console doctrine:database:drop --force --if-exists
	docker compose exec app-admin php bin/console doctrine:database:create
	docker compose exec app-admin php bin/console doctrine:migration:migrate --no-interaction
	docker compose exec app-admin php bin/console doctrine:fixtures:load --no-interaction

reset: reset-elastic reset-database

test: reset
	docker compose exec app-admin php bin/phpunit
