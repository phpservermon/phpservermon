Monitoring checklist
====================

Use this list to seed monitoring and alerting for PHP Server Monitor or any PHP stack. Pick only the pieces that match your stack (for example: FPM+Nginx/Apache, MySQL/Postgres, Redis, queues). Start with the “minimums” and expand as you add components.

Minimums for a typical FPM + Nginx + MySQL + Redis host
-------------------------------------------------------

* **App reachability**: Health check that boots the app, connects to DB, cache, sessions, and can write to ``/tmp`` or the configured session path.
* **PHP-FPM pools**: Active/idle processes, max children reached, listen queue length, slow requests, and request duration percentiles.
* **HTTP status codes**: Rate of 5xx/4xx plus spikes in 499/502/504. Alert on both symptoms and upstream causes (e.g., FPM queue saturation).
* **Database connections**: Max connections used, connection errors, slow connects. Track slow query fingerprints.
* **Redis cache**: Hit rate, evictions, GET/SET latency, and blocked clients or persistence failures.
* **System health**: CPU saturation, load vs. cores, free memory/swap, disk free space and I/O wait, network retransmits/drops, file descriptor limits, and time sync.

PHP runtime and app health
--------------------------

* PHP-FPM pool status: Active/idle processes, max children reached, listen queue length, slow requests, request duration percentiles.
* Fatal errors and uncaught exceptions: Rate and top error signatures.
* Slow endpoints/transactions: p95/p99 latency by route/controller; external call time (HTTP, DB, Redis).
* Health checks: App can boot, connect to DB, read/write cache, write to tmp/session storage, queue ping.
* OPcache: Hit rate, memory usage, interned strings, restarts, and file cache issues.
* Session subsystem: Session save handler failures, storage latency (files/Redis/DB), session lock contention.

Web server layer (Nginx/Apache)
--------------------------------

* HTTP status codes: Spikes in 5xx/4xx, 499 (client abort), 502/504 (upstream issues).
* Upstream errors: ``upstream timed out``, ``connect() failed``, ``no live upstreams``.
* Request rate and concurrency per vhost/app.
* TLS and certificates: Expiry, handshake errors, OCSP issues, SNI mismatch.
* WAF/rate limiters: Blocks/denies, top offenders, false-positive rate.

Database (MySQL/Postgres)
--------------------------

* Connection saturation: Max connections, connection errors, slow connects.
* Slow queries: Rate and top slow query fingerprints.
* Locking: Deadlocks, lock wait time, long transactions.
* Replication (if used): Lag, IO/SQL thread status, GTID gaps.
* Resource usage: Buffer pool/cache hit rate, disk read IOPS spikes, temporary table spills.

Cache / key-value stores (Redis/Memcached)
------------------------------------------

* Hit rate and evictions (memory pressure).
* Latency for GET/SET and pipeline usage.
* Redis specifics: Blocked clients, AOF/RDB persistence failures, replication lag.
* Keyspace growth: Unexpected key count or memory jump (potential leaks).

Queues / async workers (RabbitMQ/SQS/Beanstalkd/Kafka)
------------------------------------------------------

* Queue depth and age of oldest message.
* Worker health: Running worker count, restart loops, crash rate.
* Job failures: Retries, poison messages, dead-letter counts.
* Processing time percentiles.

System and OS level
-------------------

* CPU: Saturation, steal time on VMs, load vs. cores.
* Memory: Free memory, swap usage, major page faults.
* Disk: Free space, inode exhaustion, latency, I/O wait.
* Network: Packet drops, retransmits, bandwidth, DNS latency.
* File descriptors and process limits.
* Time drift (NTP/chrony) to avoid TLS/session issues.

Security and integrity
----------------------

* Authentication anomalies: Login failure spikes, credential stuffing patterns.
* Unexpected file changes: Webroot integrity, new PHP files, changed configs (tripwire/AIDE).
* SSH/sudo events: New keys, unusual logins, geo/ASN anomalies if tracked.
* Dependency alerts: Known vulnerable packages (Composer audit/SCA).

Logging and alerting hygiene
----------------------------

* Log volume spikes that could fill disks or hide signal.
* Missing logs indicating the app or shipper stopped.
* Alert quality: Tie symptoms (e.g., 502s) to likely causes (e.g., FPM max children reached).

Optional observability add-ons
------------------------------

* APM tracing (e.g., OpenTelemetry) across request → DB → cache → external APIs.
* SLOs: Error budget, availability percentage, latency targets per critical endpoint.
