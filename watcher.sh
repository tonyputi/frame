#!/bin/bash

# make use start-stop-daemon facility

trap teardown SIGUSR1

TARGET_DIR="/var/run/watcher"
RELOAD_FILE="$TARGET_DIR/reload"

mkdir -p $TARGET_DIR
chown -R root.www-data $TARGET_DIR
chmod -R 664 $TARGET_DIR

teardown() {
    # do something
    exit 0
}

while true; do
    [ -f $RELOAD_FILE ] && {
        echo "nginx -t && service nginx reload"
        sqlite3 database.sqlite "UPDATE something SET is_applied = 0 WHERE 1";
        sqlite3 database.sqlite "UPDATE something SET is_applied = 1 WHERE id = $ID";
        rm -rf $RELOAD_FILE
    }

    sleep 1
done