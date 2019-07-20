SHELL := /bin/sh

.DEFAULT_GOAL := help

# TODO: Add version to images

help:
	@echo "Please use 'make <target>' where <target> is one of"
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z\._-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

run: ## Run the main script
	@docker run --rm --workdir=/app -v $(CURDIR):/app survivorbat/random-image-generator /app/src/bin/create

shell: ## Enter the shell to use php commands
	@docker run --rm -u php --entrypoint=/bin/sh -it -v $(CURDIR):/app survivorbat/random-image-generator

install: ## Install the dependencies with a throwaway docker container
	@docker run --rm -u php --entrypoint=/usr/bin/composer -v ${CURDIR}/src:/app survivorbat/random-image-generator install

cs-fixer: ## Run php-cs-fixer on the source code
	@docker run --rm -u php -v ${CURDIR}/src:/app survivorbat/random-image-generator vendor/bin/php-cs-fixer fix src/

phpstan: ## Run phpstan on the source code
	@docker run --rm -u php -v ${CURDIR}/src:/app survivorbat/random-image-generator vendor/bin/phpstan analyze --level=5 -a autoload.php src

test: ## Run phpunit tests and generate coverage
	@docker run --rm -u php -v ${CURDIR}:/app survivorbat/random-image-generator src/vendor/bin/phpunit src/tests/
