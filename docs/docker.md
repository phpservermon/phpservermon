Docker usage
============

This repository includes a Docker setup to run PHP Server Monitor locally or in a containerized environment.

Prerequisites
-------------

* Docker
* Docker Compose v2

Quick start
-----------

1. Build and start the containers::

       docker compose up --build

2. Open the application at http://localhost:8080.
3. Complete the installation wizard using the database credentials from ``docker-compose.yml`` (defaults: ``psm``/``changeme`` at host ``db``).
4. The container automatically writes a ``config.php`` using the environment variables defined in ``docker-compose.yml``.

Configuration
-------------

Environment variables that influence the generated ``config.php``:

* ``PSM_DB_HOST`` (default: ``db``)
* ``PSM_DB_NAME`` (default: ``psm``)
* ``PSM_DB_USER`` (default: ``psm``)
* ``PSM_DB_PASS`` (default: ``psm``)
* ``PSM_DB_PREFIX`` (default: ``monitor_``)
* ``PSM_DB_PORT`` (default: ``3306``)
* ``PSM_BASE_URL`` (default: empty)
* ``PSM_PUBLIC`` (default: ``false``)
* ``PSM_WEBCRON_KEY`` (default: empty)
* ``PSM_WEBCRON_ENABLE_IP_WHITELIST`` (default: ``true``)
* ``PSM_UPTIME_ARCHIVE`` (default: ``monthly``)
* ``PSM_MAX_GRAPH_RECORDS`` (default: ``5000``)

Volumes
-------

The compose file declares volumes for the generated ``config.php``, log files, and database storage to keep them between container restarts.

Useful commands
---------------

* Rebuild after code changes::

       docker compose build app

* Tail logs from the running containers::

       docker compose logs -f
