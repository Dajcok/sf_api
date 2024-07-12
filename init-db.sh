#!/bin/bash
set -e

# Create sf_db_test database
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    CREATE DATABASE sf_db_test;
EOSQL
