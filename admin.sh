#!/usr/bin/env bash
# Usage: admin.sh up|down|shell
echo "Usage: admin.sh up|down|build|ls|init|perms|shell"
export CONTAINER="laminas_2"
if [[ "$1" = "up" ]]; then
    docker-compose up -d
    docker exec $CONTAINER /bin/bash -c "/tmp/init.sh --perms --start"
elif [[ "$1" = "down" ]]; then
    docker-compose down
    sudo chown -R $USER:$USER *
elif [[ "$1" = "shell" ]]; then
    docker exec -it $CONTAINER /bin/bash
elif [[ "$1" = "ls" ]]; then
    docker container ls
elif [[ "$1" = "init" ]]; then
    docker exec $CONTAINER /bin/bash -c "/tmp/init.sh --init"
elif [[ "$1" = "build" ]]; then
    docker-compose build --force-rm --no-cache
elif [[ "$1" = "perms" ]]; then
    docker exec $CONTAINER /bin/bash -c "/tmp/init.sh --perms"
fi
