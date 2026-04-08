# Laravel

## Role In App 2.0

Laravel is the center of the application stack. It owns routing, middleware, validation, authentication flow, logging integration, database access, queues, and automated tests.

## How We Use It

* route HTTP traffic through `routes/`
* use middleware for request-level concerns such as auth and request IDs
* use form requests for non-trivial validation
* keep controllers thin and move reusable logic into `app/Platform/`
* use migrations for schema changes
* use feature tests for request flows and database effects

## Best Practices For This Repo

* prefer Laravel conventions unless the project has a clear architectural reason to diverge
* prefer middleware over repeated controller checks
* prefer form requests over inline validation once rules grow beyond trivial cases
* prefer Eloquent and migrations for application-owned tables
* prefer feature tests for auth, logging, tenancy, and provisioning behavior
* keep `.env` local and out of source control
* serve Laravel from the web root, not a nested subdirectory

## Implementation Notes

* current auth uses Laravel session authentication
* current logs use Laravel's logging system plus custom database-backed platform logging
* request correlation starts in middleware and is reused in logs

## Official References

* Laravel installation: https://laravel.com/docs/12.x/installation
* Laravel middleware: https://laravel.com/docs/12.x/middleware
* Laravel authentication: https://laravel.com/docs/12.x/authentication
* Laravel validation: https://laravel.com/docs/12.x/validation
* Laravel logging: https://laravel.com/docs/12.x/logging
* Laravel testing: https://laravel.com/docs/12.x/testing
* Laravel HTTP tests: https://laravel.com/docs/12.x/http-tests
* Laravel database testing: https://laravel.com/docs/12.x/database-testing
* Laravel frontend and Vite integration: https://laravel.com/docs/12.x/frontend

## Practical Commands

```bash
php artisan route:list --except-vendor
php artisan test --display-warnings
php artisan migrate
./vendor/bin/pint --test
```
