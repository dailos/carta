.PHONY: shell build
default:run
build:
	docker-compose build && docker-compose run app composer install
shell:
	docker-compose run app bash
