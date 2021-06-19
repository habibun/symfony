CONSOLE				= bin/console
# A little hack if you want increase Composer memory
# COMPOSER			= php -d memory_limit=-1 /usr/local/bin/composer
COMPOSER			= composer
PHPUNIT				= SYMFONY_PHPUNIT_VERSION=9.1.1 bin/phpunit
YARN				= yarn

##
###------------#
###    Help    #
###------------#
##

.DEFAULT_GOAL := 	help
help:				## Display all help messages
					@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-20s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: 			help

##
###---------------------------#
###    Project commands (SF)  #
###---------------------------#
##

install:			.env.local vendor node_modules assets db-init ## Launch project : copy the env and start the project with vendors, assets and DB

sf-console\:%:		## Calling Symfony console
					$(CONSOLE) $* $(ARGS)

.PHONY:				install install-prod

##
###-------------------------#
###    Doctrine commands    #
###-------------------------#
##

db-destroy: 		## Execute doctrine:database:drop --force command
					$(CONSOLE) doctrine:database:drop --force --if-exists
					$(CONSOLE) doctrine:database:drop --force --env=test --if-exists

db-create:			## Execute doctrine:database:create
					$(CONSOLE) doctrine:database:create --if-not-exists -vvv

db-migrate:			## Execute doctrine:migrations:migrate
					$(CONSOLE) doctrine:migrations:migrate --allow-no-migration --no-interaction --all-or-nothing

db-fixtures: 		## Execute doctrine:fixtures:load
					$(CONSOLE) doctrine:fixtures:load --no-interaction

db-fixtures-test: 	## Execute doctrine:fixtures:load fo test env
					$(CONSOLE) doctrine:database:create -vvv --env=test
					$(CONSOLE) doctrine:migrations:migrate --allow-no-migration --no-interaction --all-or-nothing --env=test
					$(CONSOLE) doctrine:fixtures:load --no-interaction --env=test

db-diff:			## Execute doctrine:migration:diff
					$(CONSOLE) doctrine:migrations:diff --formatted

db-validate:		## Validate the doctrine ORM mapping
					$(CONSOLE) doctrine:schema:validate

db-init:			db-create db-migrate db-fixtures

db-update: 			vendor db-diff db-migrate

.PHONY: 			db-wait db-destroy db-create db-migrate db-fixtures db-fixtures-test db-diff db-validate db-init db-update


##
###------------#
###    Utils   #
###------------#
##

cc:					## Clear cache
					symfony console cache:clear

cc-prod:			## Clear cache for prod
					$(CONSOLE) cache:clear --env=prod

assets:				node_modules ## Install node_modules and compile with Yarn
					$(YARN) run dev

watch:				node_modules ## Install node_modules and compile with Yarn with watch option
					$(YARN) run watch

clear-assets:		## Remove build directory
					rm -rvf ./public/build

clean:				qa-clean-conf ## Remove all generated files
					rm -rvf ./vendor ./node_modules ./var
					rm -rvf ./bin/.phpunit ./behat.yml

clear:				db-destroy clear-assets clean ## Remove all generated files and db

update:				node_modules ## Update dependencies
					$(COMPOSER) update --lock --no-interaction
					$(YARN) upgrade

update-prod:		## Update dependencies for prod
					$(COMPOSER) update --no-dev --optimize-autoloader
					$(CONSOLE) cache:clear --env=prod
					$(COMPOSER) dump-autoload --optimize --no-dev --classmap-authoritative
					# sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx var/cache var/log
                    # sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx var/cache var/log
re-init:            db-destroy db-create db-migrate db-fixtures
.PHONY:				cc cc-prod assets watch clear-assets clean clear update update-prod re-init


