.PHONY: run test install

run:
	docker-compose run --rm php bin/fetch-currency.php

test: vendor
	docker-compose run --rm php vendor/bin/php-cs-fixer fix

install:
	docker-compose run --rm php composer.phar install

vendor: vendor/bin/php-cs-fixer
	@

vendor/%:
	docker-compose run --rm php composer.phar install
