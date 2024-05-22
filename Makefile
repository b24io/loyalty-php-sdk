default:
	@echo "make needs target:"
	@egrep -e '^\S+' ./Makefile | grep -v default | sed -r 's/://' | sed -r 's/^/ - /'

lint-phpstan:
	vendor/bin/phpstan analyse
lint-phpinsights:
	vendor/bin/phpinsights analyse ./src
lint-rector:
	vendor/bin/rector process --dry-run
lint-rector-fix:
	vendor/bin/rector process

test-integration:
	php vendor/bin/phpunit --colors=always --testsuite integration-tests