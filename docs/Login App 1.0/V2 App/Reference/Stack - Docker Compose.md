# Docker Compose

## Role In App 2.0

Docker Compose is the standard local development contract for the stack.

## Current Services

* `app`
* `node`
* `postgres`
* `redis`
* `mailpit`

## Best Practices For This Repo

* treat Compose as the default local workflow even if some contributors also run services natively
* use named volumes for persistent local database and Redis state
* use health checks for dependency readiness
* use `docker compose config` when verifying environment substitution and service definitions
* use `docker compose exec` for live debugging inside running services

## Official References

* Docker Compose docs index: https://docs.docker.com/compose/
* Compose quickstart: https://docs.docker.com/compose/gettingstarted/
* How Compose works: https://docs.docker.com/compose/intro/compose-application-model/

## Practical Commands

```bash
docker compose config
docker compose up --build
docker compose ps
docker compose logs -f
docker compose exec app php artisan test --display-warnings
docker compose down
```
