
reset-elastic:
	docker compose exec app-admin curl -s -X DELETE http://elasticsearch:9200/clients
	docker compose exec app-admin curl -s -X DELETE http://elasticsearch:9200/owners

reset-database:
	docker compose exec app-admin php bin/console doctrine:database:drop --force --if-exists
	docker compose exec app-admin php bin/console doctrine:database:create
	cat docker/postgresql/01-users.sql | docker compose exec -e PGPASSWORD=symfony -T db psql -U symfony -d admin
	docker compose exec app-admin php bin/console doctrine:migrations:migrate --no-interaction
	docker compose exec app-admin php bin/console doctrine:fixtures:load --no-interaction

reset: reset-elastic reset-database

test: reset
	docker compose exec app-admin php bin/phpunit tests/E2E

behat:
	docker compose exec app-admin vendor/bin/behat
