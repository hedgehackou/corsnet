project-init:
	composer install
	cp .env.example .env
	php artisan key:generate
	php artisan storage:link

sniff:
	./vendor/bin/phpstan analyse

cs:
	./vendor/bin/phpcs --standard=PSR12 --error-severity=1 --warning-severity=8 --colors ./app; \
	./vendor/bin/phpcs --standard=PSR12 --error-severity=1 --warning-severity=8 --colors --report=summary ./app; return 0;

csfix:
	./vendor/bin/phpcbf --standard=PSR12 ./app; return 0;
