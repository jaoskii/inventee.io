#!/bin/bash
# Import the local web_universe database into Railway MySQL.
#
# Usage:
#   ./scripts/railway-import.sh 'mysql://root:PASSWORD@HOST:PORT/railway' [dump.sql]
#
# Get the URL from: Railway -> MySQL service -> Connect tab -> "MYSQL_PUBLIC_URL"
# (quote it — passwords often contain shell-special characters).
#
# The main dump lacks stored procedures/triggers, so this script first
# re-exports routines+triggers from the local MySQL and applies them after.
set -euo pipefail

MYSQL_BIN=/usr/local/mysql/bin
DUMP="${2:-$HOME/Downloads/universe_dump2k26.sql}"
ROUTINES=/tmp/web_universe_routines.sql
URL="${1:?Usage: $0 'mysql://root:pass@host:port/railway' [dump.sql]}"

# Parse mysql://user:pass@host:port/db
proto_stripped="${URL#mysql://}"
userpass="${proto_stripped%%@*}"
hostportdb="${proto_stripped#*@}"
RUSER="${userpass%%:*}"
RPASS="${userpass#*:}"
RHOST="${hostportdb%%:*}"
portdb="${hostportdb#*:}"
RPORT="${portdb%%/*}"

[ -f "$DUMP" ] || { echo "Dump not found: $DUMP"; exit 1; }

echo "==> 1/4 Exporting stored procedures + triggers from local web_universe"
echo "    (enter your LOCAL MySQL root password)"
"$MYSQL_BIN/mysqldump" -uroot -p --routines --triggers \
    --no-create-info --no-data --no-create-db --skip-opt \
    web_universe > "$ROUTINES"
echo "    exported $(grep -cE 'CREATE.*(PROCEDURE|FUNCTION|TRIGGER)' "$ROUTINES" || true) routine/trigger definitions"

echo "==> 2/4 Importing main dump ($(du -h "$DUMP" | cut -f1)) to Railway — this can take a while"
"$MYSQL_BIN/mysql" -h "$RHOST" -P "$RPORT" -u "$RUSER" -p"$RPASS" < "$DUMP"

echo "==> 3/4 Importing routines + triggers"
"$MYSQL_BIN/mysql" -h "$RHOST" -P "$RPORT" -u "$RUSER" -p"$RPASS" web_universe < "$ROUTINES"

echo "==> 4/4 Verifying"
"$MYSQL_BIN/mysql" -h "$RHOST" -P "$RPORT" -u "$RUSER" -p"$RPASS" -e "
  SELECT COUNT(*) AS tables_imported FROM information_schema.tables WHERE table_schema='web_universe';
  SELECT COUNT(*) AS procedures_imported FROM information_schema.routines WHERE routine_schema='web_universe';
  SELECT COUNT(*) AS triggers_imported FROM information_schema.triggers WHERE trigger_schema='web_universe';"

rm -f "$ROUTINES"
echo "Done. Set DB_SCHEMA=web_universe in the Railway app service variables."
