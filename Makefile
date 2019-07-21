SHELL := /bin/sh

MAKEFLAGS := --silent --ignore-errors --no-print-directory

.DEFAULT_GOAL := help

# TODO: Add version to images

help:
	@echo "Please use 'make <target>' where <target> is one of"
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z\._-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

run: ## Run a command in the application, usage: make run cmd=<command>
ifndef cmd
	@echo "You need to use this command like: make run cmd='<your command>'"
else
	@docker run --rm --workdir=/app -v $(CURDIR):/app survivorbat/random-image-generator /app/src/bin/console ${cmd}
endif

shell: ## Enter the shell to use php commands
	@chmod u+x src/bin/console
	@docker run --rm -u php --entrypoint=/bin/sh --workdir=/app/src -it -v $(CURDIR):/app survivorbat/random-image-generator

install: ## Install the dependencies with a throwaway docker container
	@docker run --rm -u php --entrypoint=/usr/bin/composer -v ${CURDIR}/src:/app survivorbat/random-image-generator install

cs-fixer: ## Run php-cs-fixer on the source code (not supported yet)
	@docker run --rm -u php -v ${CURDIR}/src:/app survivorbat/random-image-generator vendor/bin/php-cs-fixer fix src/

phpstan: ## Run phpstan on the source code
	@docker run --rm -u php -v ${CURDIR}/src:/app survivorbat/random-image-generator vendor/bin/phpstan analyze --level=5 -a autoload.php src

test: ## Run phpunit tests and generate coverage
	@docker run --rm -u php -v ${CURDIR}:/app survivorbat/random-image-generator src/vendor/bin/phpunit src/tests/
