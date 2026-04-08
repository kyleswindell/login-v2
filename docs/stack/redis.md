# Redis

## Role In App 2.0

Redis is infrastructure support for cache, queues, and fast transient state.

## How We Use It

* Laravel cache backend
* Laravel queue backend
* future rate limiting or short-lived coordination state when useful

## Best Practices For This Repo

* do not treat Redis as the source of truth for business data
* keep durable records in PostgreSQL
* be explicit about whether a Redis use case is cache, queue, lock, or ephemeral state
* document persistence expectations for any environment where Redis stores more than disposable cache data

## Operational Notes

* Redis client connection behavior and limits matter under load
* persistence strategy should match the use case
* cache-only environments can use lighter persistence expectations than queue-heavy or stateful environments

## Official References

* Redis development docs: https://redis.io/docs/latest/develop
* Redis client handling: https://redis.io/docs/latest/develop/reference/clients/
* Redis persistence: https://redis.io/docs/latest/operate/oss_and_stack/management/persistence/

## Practical Notes

For App 2.0, Redis should stay narrowly scoped until a concrete feature justifies broader usage.
