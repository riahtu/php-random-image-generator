SHELL := /bin/sh

MAKEFLAGS := --silent --ignore-errors --no-print-directory

.DEFAULT_GOAL := help

help:
	@echo "Please use 'make <target>' where <target> is one of"
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z\._-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

run: ## Run a command in the application, usage: make run cmd=<command>
ifndef cmd
	@echo "You need to use this command like: make run cmd='<your command>'"
else
	@docker run --rm --workdir=/app -v $(CURDIR):/app survivorbat/random-image-generator:v0.1 /app/src/bin/console ${cmd}
endif

shell: ## Enter the shell to use php commands
	@chmod u+x src/bin/console
	@docker run --rm -u php --entrypoint=/bin/sh --workdir=/app/src -it -v $(CURDIR):/app survivorbat/random-image-generator:v0.1

install: ## Install the dependencies with a throwaway docker container
	@docker run --rm -u php --entrypoint=/usr/bin/composer -v ${CURDIR}/src:/app survivorbat/random-image-generator:v0.1 install

cs-fixer: ## Run php-cs-fixer on the source code (not supported yet)
	@echo "Php-cs-fixer does not yet support php 7.4 unfortunately :("
	#@docker run --rm -u php -v ${CURDIR}/src:/app survivorbat/random-image-generator:v0.1 vendor/bin/php-cs-fixer fix src/

phpstan: ## Run phpstan on the source code
	@docker run --rm -u php -v ${CURDIR}/src:/app survivorbat/random-image-generator:v0.1 vendor/bin/phpstan analyze --level=5 -a autoload.php src

test: ## Run phpunit tests and generate coverage
	@docker run --rm -u php -v ${CURDIR}:/app survivorbat/random-image-generator:v0.1 src/vendor/bin/phpunit src/tests/

build: ## Build a docker image out of the application, usage: make build tag='<tag>'
ifndef tag
	@echo "You need to use this command like: make build tag='<tag>'"
else
	@docker build -f docker/random-image-generator/Dockerfile . -t ${tag}
endif
