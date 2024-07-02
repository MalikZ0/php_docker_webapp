#!/bin/bash
set -e

if [ -d "/var/lib/mysql/php_docker" ]; then
    echo "Database already initialized."
else
    echo "Initializing database..."
    mysql -u php_docker -ppassword php_docker < /docker-entrypoint-initdb.d/php_docker_table.sql
fi

exec "$@"
