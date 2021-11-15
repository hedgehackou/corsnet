project-init:
	composer install
	cp .env.example .env
	php artisan key:generate
	php artisan storage:link

update:
	# Install dependencies based on lock file
	composer install --no-interaction --prefer-dist --optimize-autoloader
	# Migrate database
	php artisan migrate --force
	# Note: If you're using queue workers, this is the place to restart them.
	# ...
	# Clear cache
	php artisan optimize

sniff:
	./vendor/bin/phpstan analyse

cs:
	./vendor/bin/phpcs --standard=PSR12 --error-severity=1 --warning-severity=8 --colors ./app; \
	./vendor/bin/phpcs --standard=PSR12 --error-severity=1 --warning-severity=8 --colors --report=summary ./app; return 0;

csfix:
	./vendor/bin/phpcbf --standard=PSR12 ./app; return 0;

test:
	./vendor/bin/phpunit
