#!/usr/bin/env bash
# Usage: admin.sh up|down|shell
echo "Usage: admin.sh up|down|build|ls|shell [ldap|admin]"
export CONTAINER1="laminas_3_ldap"
export CONTAINER2="laminas_3_phpldapadmin"
if [[ "$1" = "up" ]]; then
    docker-compose up -d
elif [[ "$1" = "down" ]]; then
    docker-compose down
elif [[ "$1" = "shell" ]]; then
    if [[ "$2" = "admin" ]]; then
        docker exec -it $CONTAINER2 /bin/bash
    else
        docker exec -it $CONTAINER1 /bin/bash
    fi
elif [[ "$1" = "ls" ]]; then
    docker container ls
elif [[ "$1" = "build" ]]; then
    docker-compose build --force-rm --no-cache
fi
