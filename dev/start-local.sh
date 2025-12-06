#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT_DIR"

if [ ! -f vendor/autoload.php ]; then
  echo "Dependencies missing. Run dev/bootstrap-local.sh first." >&2
  exit 1
fi

HOST="0.0.0.0"
PORT="8080"
DOCROOT="$ROOT_DIR"
ROUTER="public.php"

echo "Starting PHP built-in server on http://$HOST:$PORT using $ROUTER"
php -S "$HOST:$PORT" -t "$DOCROOT" "$ROUTER"
