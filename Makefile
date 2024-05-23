default:
	@echo "make needs target:"
	@egrep -e '^\S+' ./Makefile | grep -v default | sed -r 's/://' | sed -r 's/^/ - /'


init:
	docker-compose down --remove-orphans
	docker-compose build
	docker-compose run --rm php-cli composer install
    docker-compose run --rm php-cli chown -R www-data:www-data /var/www/html/var/
	docker-compose up -d

cli-bash:
	docker-compose run --rm php-cli sh $(filter-out $@,$(MAKECMDGOALS))
integration-tests:
	docker-compose run --rm php-cli vendor/bin/phpunit --colors=always --testsuite=integration-tests
lint-phpstan:
	docker-compose run --rm php-cli vendor/bin/phpstan analyse --memory-limit 1G
lint-rector:
	docker-compose run --rm php-cli vendor/bin/rector process --dry-run
lint-rector-fix:
	docker-compose run --rm php-cli vendor/bin/rector process

composer-install:
	@echo "install dependencies"
	docker-compose run --rm php-cli composer install
composer-update:
	@echo "update dependencies"
	docker-compose run --rm php-cli composer update

