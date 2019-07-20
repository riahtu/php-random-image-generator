SHELL := /bin/sh

.DEFAULT_GOAL := help

help:
	@echo "Please use 'make <target>' where <target> is one of"
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z\._-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

run: ## Run the main script
	@docker run --rm --workdir=/app -v $(CURDIR):/app survivorbat/random-image-generator /app/src/bin/create.php

shell: ## Enter the shell to use php commands
	@docker run --rm -u php --entrypoint=/bin/sh -it -v $(CURDIR)/src:/app survivorbat/random-image-generator

install: ## Install the dependencies with a throwaway docker container
	@docker run --rm -u php --entrypoint=/usr/bin/composer -v ${CURDIR}/src:/app survivorbat/random-image-generator install
