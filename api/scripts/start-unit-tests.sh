#!/bin/bash

# Clear and cache the configuration for the testing environment
php artisan config:clear
php artisan config:cache --env=testing

# Run the feature tests and capture the exit code
vendor/bin/phpunit --testsuite Unit
TEST_EXIT_CODE=$?

# Clear and cache the configuration for the default environment
php artisan config:clear --env=testing
php artisan config:cache

# Exit with the original exit code from the tests
exit $TEST_EXIT_CODE
